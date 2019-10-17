<?php

declare(strict_types=1);

namespace UTMS\Models;

use App\Models\Model;
use Illuminate\Support\Facades\Log;
use UTMS\Events\ChangeStatusEvent;
use UTMS\Exceptions\FSM\StatusLockException;
use Urland\Exceptions\Server\InternalServerException;
use Urland\FSM\FSM as UrlandFSM;

trait FSM
{
    /**
     * @var \Urland\FSM\FSM
     */
    private $fsmObject;

    /*
     * 状态常量路径是必须的
     *
     * protected const CONS_STATUS_PATH;
     */

    /**
     * 初始化 FSM
     *
     * @return \Urland\FSM\FSM
     */
    public function initFSM(): UrlandFSM
    {
        if ($this->fsmObject) {
            return $this->fsmObject;
        }

        $fsm = new UrlandFSM(self::getStatusByValue($this->{self::STATUS_KEY ?? 'status'}), $this);
        foreach (self::STATUS_TRANSITIONS as $symbol => $stateArr) {
            foreach ($stateArr as $state => $nextState) {
                // 检查key是否正常，防止低级错误
                if (!is_string($state)) {
                    throw new InternalServerException('STATUS_TRANSITIONS 配置的 key 必须为字符串');
                }

                $fsm->addTransition($symbol, $state, $nextState, [self::class, "FSMChangeStatus"]);
            }
        }

        $this->fsmObject = $fsm;
        return $this->fsmObject;
    }

    /**
     * 通过状态获取值
     *
     * @param $status
     *
     * @return int
     */
    protected static function getValueByStatus($status): int
    {
        return cons()->get(self::CONS_STATUS_PATH . '.' . $status);
    }

    /**
     * 通过值取状态
     *
     * @param int $value
     *
     * @return string
     */
    protected static function getStatusByValue($value): string
    {
        return cons()->key(self::CONS_STATUS_PATH, $value);
    }

    /**
     * 执行
     *
     * @param string     $symbol
     * @param null|array $extend
     *
     * @return bool
     */
    public function process(string $symbol, ?array $extend = null): bool
    {
        $this->initFSM();


        if (!$this->fsmObject->process($symbol, $extend)) {
            throw new StatusLockException(__CLASS__ . " 状态切换异常: 操作指令 = $symbol, ID = $this->id, currentStatus = " . $this->{self::STATUS_KEY ?? 'status'});
        }

        return true;
    }

    /**
     * 判断当前是否可以执行
     *
     * @param string $symbol
     *
     * @return bool
     */
    public function can(string $symbol): bool
    {
        $this->initFSM();
        return $this->fsmObject->can($symbol);
    }

    /**
     * 当前状态判断
     *
     * @param string $status
     *
     * @return bool
     */
    public function currentStatusIs(string $status): bool
    {
        if (self::getValueByStatus($status) === $this->{self::STATUS_KEY ?? 'status'}) {
            return true;
        }

        return false;
    }

    /**
     * 上一状态判断
     *
     * @param string $status
     *
     * @return bool
     */
    public function previousStatusIs(string $status): bool
    {
        if ($this->fsmObject->getPreviousState() === $status) {
            return true;
        }

        return false;
    }

    /**
     * 状态切换函数
     *
     * @param string            $symbol
     * @param \App\Models\Model $model
     * @param string            $currentStatus
     * @param string            $nextStatus
     * @param array|null        $extend
     *
     * @return bool
     */
    public static function FSMChangeStatus(
        string $symbol,
        Model &$model,
        string $currentStatus,
        string $nextStatus,
        ?array $extend
    ): bool {
        //TODO 检查请求来源可靠性

        $currentStatusValue = self::getValueByStatus($currentStatus);
        $nextStatusValue    = self::getValueByStatus($nextStatus);
        $data               = [self::STATUS_KEY ?? 'status' => $nextStatusValue];
        $selfUpdate         = collect($extend)->except('status_log');
        if ($selfUpdate->isNotEmpty()) {
            $data = $selfUpdate->merge($data)->toArray();
        }

        $class = get_class($model);
        if (!(new $class)->where('id', $model->id)
            ->where(self::STATUS_KEY ?? 'status', $currentStatusValue)
            ->update($data)) {
            throw new StatusLockException(__CLASS__ . " 状态切换异常: 操作指令 = $symbol, ID = $model->id , $currentStatus => $nextStatus");
        }

        $attributes = array_merge($model->getAttributes(), $data);
        $model->setRawAttributes($attributes, true);

        event(new ChangeStatusEvent($symbol, $model, $currentStatusValue, $nextStatusValue, $extend));

        return true;
    }
}
