<?php

namespace App\Http\Resources\AdminApi\Admin;

use App\Http\Resources\AdminApi\BaseResource;

/**
 * Class AdminResource
 *
 * @package App\Http\Resources
 *
 * @mixin \App\Models\Admin\Admin
 */
class AdminResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'admin_name'  => $this->admin_name,
            'admin_uuid'  => $this->admin_uuid,
            'create_time' => $this->formatDate($this->create_time),
        ];
    }
}
