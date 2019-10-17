<?php

namespace App\Http\Resources\AdminApi\Permission;

use App\Http\Resources\AdminApi\BaseResource;

class UserRoleResource extends BaseResource
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
            'role_id' => $this->role_id,
        ];
    }
}
