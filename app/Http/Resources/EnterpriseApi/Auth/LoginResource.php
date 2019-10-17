<?php

namespace App\Http\Resources\EnterpriseApi\Auth;

use App\Http\Resources\EnterpriseApi\BaseResource;

class LoginResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'token' => $this['token'],
            'user'  => [
                'user_uuid'  => $this['user']['user_uuid'],
                'user_phone' => $this['user']['user_phone'],
                'user_name'  => $this['user']['user_name'],
            ],
        ];
    }
}
