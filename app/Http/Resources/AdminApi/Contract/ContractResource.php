<?php

namespace App\Http\Resources\AdminApi\Contract;

use App\Http\Resources\AdminApi\BaseResource;

class ContractResource extends BaseResource
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
            'create_time' => $this->formatDate($this->create_time),

            'contract_uuid' => $this->contract_uuid,
            'contract_no'   => $this->contract_no,
            'contract_name' => $this->contract_name,

            'supplier_uuid' => $this->supplier_uuid,
            'supplier_name' => $this->supplier_name,

            'enterprise_uuid' => $this->enterprise_uuid,
            'enterprise_name' => $this->enterprise_name,

            'self_employ_uuid' => $this->self_employ_uuid,
            'self_employ_name' => $this->self_employ_name,

            'user_uuid' => $this->user_uuid,
            'user_name' => $this->user_name,

            'group'       => $this->group,
            'group_name'  => cons()->valueLang('contract.group', $this->group),
            'status'      => $this->status,
            'status_name' => cons()->valueLang('common.audit_status', $this->status),

            'attachment' => $this->attachment ? $this->attachment : [],
            'introduce'  => $this->introduce,

            'valid_time'     => $this->formatDate($this->valid_time),
            'applicant_name' => $this->applicant_name,
            'is_valid'       => $this->is_valid,
        ];
    }

}