<?php

namespace App\Http\Resources\AdminApi\Permission;

use App\Http\Resources\AdminApi\BaseResource;

class NodeResource extends BaseResource
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
            'id'            => $this->id,
            'method'        => $this->method,
            'uri'           => $this->uri,
            'module_name'   => $this->module_name,
            'function_name' => $this->function_name,
            'sign'          => $this->sign,
            'type'          => $this->type,
            'type_name'     => $this->type_name,
            'group'         => $this->group,
        ];
    }
}
