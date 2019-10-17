<?php

namespace App\Http\Resources\AdminApi\Permission;

use App\Http\Resources\AdminApi\BaseResource;

class NodeSignResource extends BaseResource
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
            'sign' => $this->sign,
        ];
    }
}
