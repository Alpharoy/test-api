<?php


namespace App\Http\Resources\EnterpriseApi\Contract;


use App\Http\Resources\EnterpriseApi\BaseResource;

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

            'status'      => $this->status,
            'status_name' => cons()->valueLang('common.audit_status', $this->status),

            'attachment' => $this->attachment ? $this->attachment : [],
            'introduce'  => $this->introduce,

            'valid_time'     => $this->formatDate($this->valid_time),
            'applicant_name' => $this->applicant_name,
            'is_valid'       => $this->is_valid,

            // 能否删除
            'can_update'     => $this->can_update,

            // 能否删除
            'can_delete'     => $this->can_delete,

            // 能否续签
            'can_renew'      => $this->can_renew,
        ];
    }

}