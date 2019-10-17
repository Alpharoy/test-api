<?php

namespace App\Http\Resources\AdminApi\Permission;

use App\Http\Resources\AdminApi\BaseResource;

class MenuDetailResource extends BaseResource
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
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'parent_id'   => $this->parent_id,
            'group'       => $this->group,
            'allow_nodes' => NodeResource::collection($this->allow_nodes),
        ];
    }
}
