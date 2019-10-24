<?php


namespace App\Http\Resources\EnterpriseApi\NaturalPerson;


use App\Http\Resources\EnterpriseApi\BaseResource;

/**
 * Class NaturalPersonBankCardResource
 *
 * @package App\Http\Resources\EnterpriseApi\NaturalPerson
 */
class NaturalPersonBankCardResource extends BaseResource
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

            'bank_card_uuid' => $this->bank_card_uuid,

            'bank_identity' => $this->bank_identity,
            'bank_name'     => $this->bank_name,

            'card_number'       => $this->card_number,
            'card_holder'       => $this->card_holder,
            'card_holder_phone' => $this->card_holder_phone,

            'is_default'  => $this->is_default,
            'is_verified' => $this->is_verified,
        ];
    }

}