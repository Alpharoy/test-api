<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class BaseEvent
{
    use Dispatchable, SerializesModels {
        SerializesModels::__wakeup as parent_wakeup;
    }

    public $user;

    public $globalData;

    public function __construct()
    {
        if (Auth::user()) {
            $this->user = Auth::user();
        }
        $this->globalData = global_data();
    }

    public function __wakeup()
    {
        $this->parent_wakeup();

        if (\App::runningInConsole()) {
            //命令行下执行
            if (!is_null($this->user)) {
                //恢复当前用户记录
                \Auth::setUser($this->user);
            }

            if (is_array($this->globalData)) {
                //恢复全局数据
                global_data($this->globalData);
            }
        }

    }

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getUser()
    {
        $user = Auth::user();
        if (!$user) {
            $user = $this->user;
        }
        return $user;
    }
}
