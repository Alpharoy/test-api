<?php

namespace App\Http\Resources\CommonApi\Auth;

use App\Http\Resources\CommonApi\BaseResource;

class TokenResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'token' => $this['token']
        ];
    }
}
