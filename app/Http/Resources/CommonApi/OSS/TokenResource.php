<?php

namespace App\Http\Resources\CommonApi\OSS;

use App\Http\Resources\CommonApi\BaseResource;

/**
 * Class TokenResource
 *
 * @package App\Http\Resources\CommonApi\OSS
 */
class TokenResource extends BaseResource
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
            'access_token' => $this->resource,
        ];
    }
}
