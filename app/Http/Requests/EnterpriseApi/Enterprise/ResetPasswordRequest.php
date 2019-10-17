<?php


namespace App\Http\Requests\EnterpriseApi\Enterprise;


use App\Http\Requests\EnterpriseApi\BaseRequest;

class ResetPasswordRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'new_password' => 'required|string|min:6|max:32|confirmed',
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
            'new_password' => '新密码',
        ];
    }

}