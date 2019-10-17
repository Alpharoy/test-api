<?php

namespace App\Http\Resources\EnterpriseApi\Enterprise;

use App\Http\Resources\EnterpriseApi\BaseResource;
use App\Http\Resources\EnterpriseApi\SelfEmploy\SelfEmployResource;

class EnterpriseRelationSelfEmployResource extends BaseResource
{
    /**
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'enterprise_uuid'  => $this->enterprise_uuid,
            'enterprise_name'  => $this->enterprise_name,
            'self_employ_uuid' => $this->self_employ_uuid,
            'self_employ_name' => $this->self_employ_name,
            'self_employ'      => new SelfEmployResource($this->whenLoaded('selfEmploy')),
        ];
    }

}