<?php

namespace App\Http\Requests\SupplierApi\Auth;

use App\Http\Requests\SupplierApi\BaseRequest;

class RegisterSendSmsRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_phone'  => 'bail|required|string|max:11',
            'verify_code' => 'bail|required|string|max:4',
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
            'user_phone'  => '手机号码',
            'verify_code' => '图形验证码',
        ];
    }
}
