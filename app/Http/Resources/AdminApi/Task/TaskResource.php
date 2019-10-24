<?php

namespace App\Http\Resources\AdminApi\Task;

use App\Http\Resources\AdminApi\BaseResource;

class TaskResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'record_time' => $this->formatDate($this->record_time),

            'task_uuid' => $this->task_uuid,
            'task_name' => $this->task_name,

            'project_uuid'    => $this->project_uuid,
            'project_name'    => $this->project_name,
            'supplier_uuid'   => $this->supplier_uuid,
            'supplier_name'   => $this->supplier_name,
            'enterprise_uuid' => $this->enterprise_uuid,
            'enterprise_name' => $this->enterprise_name,

            'address_code'   => $this->address_code,
            'address_name'   => $this->address_name,
            'address_detail' => $this->address_detail,
            'address_full'   => $this->address_name . $this->address_detail,

            'contact_name'         => $this->contact_name,
            'contact_phone_number' => $this->contact_phone_number,

            'introduce' => $this->introduce,

            'start_time' => $this->formatDate($this->start_time),
            'end_time'   => $this->formatDate($this->end_time),

            'project_service_charge' => $this->project_service_charge,
            'industry_type_code'     => $this->industry_type_code,
            'industry_type_name'     => $this->industry_type_name,
            'supplier_subject_uuid'  => $this->supplier_subject_uuid,
            'supplier_subject_name'  => $this->supplier_subject_name,

            'handler_object_group'              => $this->handler_object_group,
            'handler_object_uuid'               => $this->handler_object_uuid,
            'handler_object_name'               => $this->handler_object_name,
            'handler_object_phone'              => $this->handler_object_phone,
            'handler_object_certificate_number' => $this->handler_object_certificate_number,
            'handler_object_bank_identity'      => $this->handler_object_bank_identity,
            'handler_object_bank_name'          => $this->handler_object_bank_name,
            'handler_object_card_number'        => $this->handler_object_card_number,

            'task_fees'           => $this->task_fees,
            'service_charge_fees' => $this->service_charge_fees,
            'total_fees'          => $this->total_fees,
            'pay_status'          => $this->pay_status,
            'pay_status_name'     => cons()->valueLang('common.pay_status', $this->pay_status_name),
            'pay_time'            => $this->formatDate($this->pay_time),

            'handler_pay_status'      => $this->handler_pay_status,
            'handler_pay_status_name' => cons()->valueLang('common.pay_status', $this->handler_pay_status),
            'handler_pay_time'        => $this->formatDate($this->handler_pay_time),

            'is_auto_accept'   => $this->is_auto_accept,
            'is_auto_complete' => $this->is_auto_complete,

            'status'      => $this->status,
            'status_name' => cons()->valueLang('task.status', $this->status),

            'attachment' => $this->attachment ?? [],
            'pictures'   => $this->pictures ?? [],

            'source_from'      => $this->source_from,
            'source_from_name' => cons()->valueLang('common.source_from', $this->source_from),
            'source_from_uuid' => $this->source_from_uuid,
        ];
    }
}