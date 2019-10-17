<?php

namespace App\Http\Requests\AdminApi\Admin;

use App\Http\Requests\AdminApi\BaseRequest;

class UpdatePasswordRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => 'required|string|min:6|max:32',
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
            'old_password' => '旧密码',
            'new_password' => '新密码',
        ];
    }
}
