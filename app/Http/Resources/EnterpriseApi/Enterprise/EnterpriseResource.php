<?php

namespace App\Http\Resources\EnterpriseApi\Enterprise;

use App\Http\Resources\EnterpriseApi\BaseResource;

class EnterpriseResource extends BaseResource
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

            'enterprise_uuid' => $this->enterprise_uuid,
            'enterprise_name' => $this->enterprise_name,

            'industry_type_code' => $this->industry_type_code,
            'industry_type_name' => $this->industry_type_name,
            'location_code'      => $this->location_code,
            'location_name'      => $this->location_name,

            'usci_number'                             => $this->usci_number,
            'artificial_person_name'                  => $this->artificial_person_name,
            'artificial_person_phone_number'          => $this->artificial_person_phone_number,
            'artificial_person_certificate_type_code' => $this->artificial_person_certificate_type_code,
            'artificial_person_certificate_type_name' => $this->artificial_person_certificate_type_name,
            'artificial_person_certificate_number'    => $this->artificial_person_certificate_number,

            'business_scope'   => $this->business_scope,
            'business_address' => $this->business_address,

            'email'                => $this->email,
            'telephone'            => $this->telephone,
            'contact_name'         => $this->contact_name,
            'contact_phone_number' => $this->contact_phone_number,
            'introduce'            => $this->introduce,

            'tax_identification_number'  => $this->tax_identification_number,
            'invoice_title'              => $this->invoice_title,
            'bank_name'                  => $this->bank_name,
            'bank_account'               => $this->bank_account,
            'bank_reserve_mobile_number' => $this->bank_reserve_mobile_number,
            'invoice_address'            => $this->invoice_address,

            'artificial_person_certificate_photo_front' => $this->artificial_person_certificate_photo_front,
            'artificial_person_certificate_photo_back'  => $this->artificial_person_certificate_photo_back,
            'business_license_photo'                    => $this->business_license_photo,

            'status'      => $this->status,
            'status_name' => cons()->valueLang('common.audit_status', $this->status),

            'source_from'      => $this->source_from,
            'source_from_name' => cons()->valueLang('common.source_from', $this->source_from),
        ];
    }
}