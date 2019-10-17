<?php

namespace App\Http\Resources\SupplierApi\Supplier;

use App\Http\Resources\SupplierApi\BaseResource;
use App\Http\Resources\SupplierApi\NaturalPerson\NaturalPersonResource;

class SupplierRelationNaturalPersonResource extends BaseResource
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
            'supplier_uuid'  => $this->supplier_uuid,
            'supplier_name'  => $this->supplier_name,
            'user_uuid'      => $this->user_uuid,
            'natural_person' => new NaturalPersonResource($this->whenLoaded('naturalPerson')),
        ];
    }

}