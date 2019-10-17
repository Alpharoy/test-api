<?php

namespace App\Http\Requests\AdminApi\Auth;

use App\Http\Requests\AdminApi\BaseRequest;

class LoginRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account'     => 'bail|required|string|max:11',
            'password'    => 'bail|required|string|min:6|max:32',
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
            'account'     => '登录账号',
            'password'    => '登录密码',
            'verify_code' => '验证码',
        ];
    }
}
