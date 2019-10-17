<?php

namespace App\Http\Resources\EnterpriseApi\Permission;

use App\Http\Resources\EnterpriseApi\BaseResource;

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
