<?php

namespace App\Http\Resources\AdminApi\Admin;

use App\Http\Resources\AdminApi\BaseResource;


class LoginLogResource extends BaseResource
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
            'create_time' => $this->formatDate($this->create_time),
            'user_uuid'   => $this->user_uuid,
            'ip'          => $this->ip,
            'login_type'  => $this->login_type,
            'login_group' => $this->login_group,
        ];
    }
}
