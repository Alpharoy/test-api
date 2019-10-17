<?php

namespace App\Http\Resources\AdminApi\Permission;

use App\Http\Resources\AdminApi\BaseResource;

/**
 * Class RoleResource
 *
 * @package App\Http\Resources\AdminApi\Permission
 *
 * @mixin \App\Models\Permission\Role
 */
class RoleResource extends BaseResource
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
            'id'              => $this->id,
            'name'            => $this->name,
            'description'     => $this->description,
            'group'           => $this->group,
            'use_object_uuid' => $this->use_object_uuid,

            'last_modified_time' => $this->formatDate($this->last_modified_time),
            'create_user_uuid'   => $this->create_user_uuid,
            'create_user_name'   => $this->create_user_name,
            'update_user_uuid'   => $this->update_user_uuid,
            'update_user_name'   => $this->update_user_name,

            'can_modify' => $this->can_modify,

            'menu_ids' => $this->menu_ids,
        ];
    }
}
