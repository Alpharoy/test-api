<?php

namespace App\Http\Resources\CommonApi\Callback;

use App\Http\Resources\CommonApi\BaseResource;

class Pay56Resource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'success' => true
        ];
    }
}
