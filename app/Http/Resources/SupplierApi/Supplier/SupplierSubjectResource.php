<?php

namespace App\Http\Resources\SupplierApi\Supplier;

use App\Http\Resources\SupplierApi\BaseResource;

class SupplierSubjectResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'supplier_uuid' => $this->supplier_uuid,

            'supplier_subject_uuid' => $this->supplier_subject_uuid,
            'supplier_subject_name' => $this->supplier_subject_name,

            'industry_type_code' => $this->industry_type_code,
            'industry_type_name' => $this->industry_type_name,

            'introduce' => $this->introduce,

            'is_open' => $this->is_open,
        ];
    }
}