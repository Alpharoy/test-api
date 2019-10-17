<?php

namespace App\Http\Controllers\CommonApi\Callback;

use App\Http\Controllers\CommonApi\BaseController;
use App\Http\Resources\CommonApi\Callback\Pay56Resource;
use App\Models\Account\AccountPay56;
use App\Models\Account\Order\Recharge;
use App\Services\Account\Order\Pay56Service;
use App\Services\Account\Order\RechargeService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Urland\Exceptions\Client;
use Urland\Exceptions\Server;

/**
 * 支付服务 回调入口
 * TODO 2019年底前，切换为队列处理
 *
 * Class Pay56Controller
 *
 * @package App\Http\Controllers\CommonApi\Auth
 */
class Pay56Controller extends BaseController
{

    /**
     * 56pay系统回调记录
     * 由于参数由56pay定义，故该函数不定义Request
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \App\Http\Resources\CommonApi\Callback\Pay56Resource
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \InvalidArgumentException
     * @throws \Urland\Exceptions\Client\BadRequestException
     * @throws \Urland\Exceptions\Server\InternalServerException
     * @throws \Urland\Exceptions\Server\ServiceUnavailableException
     */
    public function store(Request $request)
    {
        //签名校验
        /* @var \UTMS\Pay56\Pay56Client $pay56Client */
        $pay56Client = app('pay56-client');
        $pay56Client->callbackSigVerif($request->all());

        $method = $request->input('method');
        $status = $request->input('status');
        $ext    = \GuzzleHttp\json_decode($request->input('ext'), true);
        if (!is_numeric($ext['amount'])) {
            throw new Client\BadRequestException('金额无效');
        }
        $amount = (int)$ext['amount'];

        switch ($method) {
            case 'recharge' :
                //充值回调
                $this->rechargeCallback($status, $amount, Carbon::now(), $ext);
                break;
            case 'withdraw' :
                //提现回调
                (new Pay56Service())->withdrawCallback($ext, $status, Carbon::now());
                break;
            case 'transfer' :
                //转账回调
                (new Pay56Service())->tradeCallback($ext, $status);
                break;
            default :
                throw new Server\ServiceUnavailableException('回调类型不支持');
        }

        return new Pay56Resource([]);
    }

    /**
     * 充值回调
     *
     * @param $status
     * @param $amount
     * @param $payTime
     * @param $ext
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Urland\Exceptions\Client\BadRequestException
     * @throws \Urland\Exceptions\Server\InternalServerException
     * @throws \Urland\Exceptions\Server\ServiceUnavailableException
     */
    private function rechargeCallback($status, $amount, $payTime, $ext)
    {
        if ($amount <= 0) {
            throw new Client\BadRequestException('充值金额必须大于0');
        }
        $accountPay56 = AccountPay56::where('pay56_account_no', $ext['account_no'])->firstOrFail();

        switch ($status) {
            case cons('misc.callback.pay56.success');
                //找到充值订单
                $recharge = Recharge::where('recharge_uuid', $ext['out_trade_no'])->first();
                if (!$recharge) {
                    //没找到，创建一个充值订单
                    $recharge = (new RechargeService())->createFromPay56(
                        $accountPay56->account,
                        $ext['trade_no'],
                        $amount
                    );
                }

                (new RechargeService())->successCallback($recharge, $amount, $payTime, $accountPay56->account);
                break;
            default:
                throw new Server\ServiceUnavailableException('充值状态不支持');
        }
    }
}
