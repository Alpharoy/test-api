<?php

namespace App\Http\Resources\AdminApi\Auth;

use App\Http\Resources\AdminApi\BaseResource;

class UserLoginPwdResource extends BaseResource
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
        $canUnlock = $this->canUnlock;
        return [
            'lock_time'   => $this->formatDate($this->lock_time),
            'unlock_time' => $this->formatDate($canUnlock ? $this->unlock_time : null),
            'user_uuid'   => $this->user_uuid,
            'lock_reason' => $this->lock_reason,

            'can_lock'   => !$canUnlock,
            'can_unlock' => $canUnlock,
        ];
    }
}
