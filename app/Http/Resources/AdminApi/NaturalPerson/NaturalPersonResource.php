<?php


namespace App\Http\Resources\AdminApi\NaturalPerson;


use App\Http\Resources\AdminApi\BaseResource;

/**
 * Class NaturalPersonResource
 *
 * @package App\Http\Resources\AdminApi\NaturalPerson
 */
class NaturalPersonResource extends BaseResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'create_time' => $this->formatDate($this->create_time),

            'user_uuid'  => $this->user_uuid,
            'user_name'  => $this->user_name,
            'user_phone' => $this->user_phone,

            'id_card_number'          => $this->id_card_number,
            'sex'                     => $this->sex,
            'sex_name'                => cons()->valueLang('common.sex', $this->sex),
            'birthday'                => $this->formatDate($this->birthday),
            'contact_address'         => $this->contact_address,
            'certificate_photo_front' => $this->certificate_photo_front,
            'certificate_photo_back'  => $this->certificate_photo_back,

            'is_name_verified'          => $this->is_name_verified,
            'status'                    => $this->status,
            'status_name'               => cons()->valueLang('common.audit_status', $this->status),
            'source_from'               => $this->source_from,
            'source_from_name'          => cons()->valueLang('common.source_from',
                $this->source_from),

            // 能否审核不通过
            'can_audit_failed'          => $this->can_audit_failed,
            // 能否审核通过
            'can_audit_passed'          => $this->can_audit_passed,
            // 能否撤销审核
            'can_reverse_audit'         => $this->can_reverse_audit,
            //银行卡
            'natural_person_bank_cards' => NaturalPersonBankCardResource::collection($this->whenLoaded('naturalPersonBankCards')),
        ];

    }

}