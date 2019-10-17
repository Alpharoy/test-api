<?php

namespace App\Providers;

use App\Events;
use App\Listeners;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     * 注意：由于此处事件较多，请大家注意书写注释和格式以及换行标准
     *
     * ``` 必须书写事件以及处理方法注释 ```
     * ``` 同一事件内多个处理方法空 *** 1行 *** ```
     * ``` 不同模块之间的事件空 *** 2行 *** ```
     *
     * @var array
     */
    protected $listen = [
        // 企业注册
        Events\Enterprise\RegisterEvent::class                        => [],
        // 企业创建
        Events\Enterprise\CreateEvent::class                          => [
            // 创建隐藏管理员
            Listeners\Enterprise\CreateSubscriber::class . '@createHiddenUser',
        ],
        // 企业审核通过
        Events\Enterprise\AuditSuccessEvent::class                    => [],


        // 供应商注册
        Events\Supplier\RegisterEvent::class                          => [],
        // 供应商创建
        Events\Supplier\CreateEvent::class                            => [
            // 创建隐藏管理员
            Listeners\Supplier\CreateSubscriber::class . '@createHiddenUser',
        ],
        // 供应商审核通过
        Events\Supplier\AuditSuccessEvent::class                      => [],


        // 供应商行业类型科目更新
        Events\Supplier\SupplierSubjectUpdateEvent::class             => [
            // 影响项目行业类型是否启用字段
            Listeners\Supplier\SupplierSubjectSubscriber::class . '@openStatusEffect',
        ],


        // 自然人添加
        Events\NaturalPerson\CreateEvent::class                       => [
            // 实名认证检查
            Listeners\NaturalPerson\NaturalPersonSubscriber::class . '@nameVerify',
        ],


        // 自然人银行卡添加
        Events\NaturalPerson\NaturalPersonBankCard\CreateEvent::class => [
            // 银行卡三要素验证
            Listeners\NaturalPerson\NaturalPersonBankCard\NaturalPersonBankCardSubscriber::class . '@bankCardVerify',
        ],
        // 自然人银行卡更新
        Events\NaturalPerson\NaturalPersonBankCard\UpdateEvent::class => [
            // 银行卡三要素验证
            Listeners\NaturalPerson\NaturalPersonBankCard\NaturalPersonBankCardSubscriber::class . '@bankCardVerify',
        ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [];


    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
