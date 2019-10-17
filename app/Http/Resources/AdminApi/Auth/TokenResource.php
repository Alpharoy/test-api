<?php

namespace App\Http\Resources\AdminApi\Auth;

use App\Http\Resources\AdminApi\BaseResource;

class TokenResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'token'   => $this['token'],
            'web_url' => $this['web_url'],
        ];
    }
}
