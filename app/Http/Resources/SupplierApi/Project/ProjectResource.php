<?php


namespace App\Http\Resources\SupplierApi\Project;


use App\Http\Resources\SupplierApi\BaseResource;

class ProjectResource extends BaseResource
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

            'supplier_uuid' => $this->supplier_uuid,
            'supplier_name' => $this->supplier_name,

            'enterprise_uuid' => $this->enterprise_uuid,
            'enterprise_name' => $this->enterprise_name,

            'contract_uuid' => $this->contract_uuid,
            'contract_no'   => $this->contract_no,
            'contract_name' => $this->contract_name,

            'project_uuid' => $this->project_uuid,
            'project_name' => $this->project_name,

            'charge_person_name'         => $this->charge_person_name,
            'charge_person_phone_number' => $this->charge_person_phone_number,

            'industry_type_code' => $this->industry_type_code,
            'industry_type_name' => $this->industry_type_name,

            'employment_type_code' => $this->employment_type_code,
            'employment_type_name' => $this->employment_type_name,

            'service_charge' => $this->service_charge,

            'status'      => $this->status,
            'status_name' => cons()->valueLang('common.audit_status', $this->status),

            'address_code'   => $this->address_code,
            'address_name'   => $this->address_name,
            'address_detail' => $this->address_detail,

            'introduce'  => $this->introduce,
            'attachment' => $this->attachment ? $this->attachment : [],

            'is_auto_accept'            => $this->is_auto_accept,
            'is_auto_complete'          => $this->is_auto_complete,
            'is_open'                   => $this->is_open,
            'is_industry_type_open'     => $this->is_industry_type_open,

            // 能否审核不通过
            'can_audit_failed'          => $this->can_audit_failed,
            // 能否审核通过
            'can_audit_passed'          => $this->can_audit_passed,
            // 能否撤销审核
            'can_reverse_audit'         => $this->can_reverse_audit,

            // 能否更改服务费
            'can_update_service_charge' => $this->can_update_service_charge,
        ];
    }

}