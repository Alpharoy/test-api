<?php

namespace App\Http\Requests\AdminApi\NaturalPerson;

use App\Http\Requests\AdminApi\BaseRequest;
use UTMS\Validator\LuhnVerify;

class NaturalPersonBankCardUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bank_identity'     => 'required|string|max:12',
            'card_number'       => [
                'required',
                'string',
                'max:20',
                function ($attribute, $value, $fail) {
                    if (!LuhnVerify::validateBankCardNo($value)) {
                        return $fail('不是有效的银行卡卡号');
                    }
                },
            ],
            'card_holder_phone' => 'required|string|size:11|phone_number',
            'is_default'        => 'required|bool',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'bank_identity'     => '银行域名识别号',
            'card_number'       => '银行卡卡号',
            'card_holder_phone' => '持卡人手机号码',
            'is_default'        => '是否默认',
        ];
    }
}