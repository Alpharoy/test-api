<?php

namespace App\Http\Requests\SupplierApi\Auth;

use App\Http\Requests\SupplierApi\BaseRequest;

class RegisterVerifySmsCodeRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_name'  => 'bail|required|string|max:16',
            'user_phone' => 'bail|required|string|max:11',
            'password'   => 'required|string|min:6|max:32|confirmed',

            'sms_code' => 'bail|required|string|max:6',
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
            'user_name'  => '姓名',
            'user_phone' => '手机号码',
            'password'   => '密码',

            'sms_code' => '手机验证码',
        ];
    }
}
