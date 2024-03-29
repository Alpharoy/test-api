<?php

namespace App\Http\Resources\SupplierApi\Supplier;

use App\Http\Resources\SupplierApi\Auth\UserLoginPwdResource;
use App\Http\Resources\SupplierApi\BaseResource;


class SupplierUserResource extends BaseResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user_uuid'       => $this->user_uuid,
            'user_name'       => $this->user_name,
            'user_phone'      => $this->user_phone,
            'create_time'     => $this->formatDate($this->create_time),
            'user_login_pwd'  => new UserLoginPwdResource($this->whenLoaded('userLoginPwd')),
            // 能否锁定（这里的锁定指的是能否操作锁定/解锁）
            'can_lock'        => $this->can_lock,
            // 能否更新权限
            'can_update_role' => $this->can_update_role,
        ];
    }
}
