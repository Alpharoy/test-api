<?php

namespace App\Http\Resources\SupplierApi\Supplier;

use App\Http\Resources\SupplierApi\BaseResource;
use App\Http\Resources\SupplierApi\SelfEmploy\SelfEmployResource;

class SupplierRelationSelfEmployResource extends BaseResource
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
            'supplier_uuid'    => $this->supplier_uuid,
            'supplier_name'    => $this->supplier_name,
            'self_employ_uuid' => $this->self_employ_uuid,
            'self_employ_name' => $this->self_employ_name,
            'self_employ'      => new SelfEmployResource($this->whenLoaded('selfEmploy')),
        ];
    }

}