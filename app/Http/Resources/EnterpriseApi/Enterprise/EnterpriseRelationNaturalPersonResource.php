<?php

namespace App\Http\Resources\EnterpriseApi\Enterprise;

use App\Http\Resources\EnterpriseApi\BaseResource;
use App\Http\Resources\EnterpriseApi\NaturalPerson\NaturalPersonResource;

class EnterpriseRelationNaturalPersonResource extends BaseResource
{

    public function toArray($request)
    {
        return [
            'enterprise_uuid' => $this->enterprise_uuid,
            'enterprise_name' => $this->enterprise_name,
            'user_uuid'       => $this->user_uuid,
            'natural_person'  => new NaturalPersonResource($this->whenLoaded('naturalPerson')),
        ];
    }

}