<?php

namespace App\Http\Requests\AdminApi\Admin;

use App\Http\Requests\AdminApi\BaseRequest;

class AdminUserCreateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_phone' => 'required|string|size:11|phone_number',
            'user_name'  => 'bail|required|string|max:16',
            'password'   => 'required|string|min:6|max:32',
            'role_ids'   => 'nullable|array',
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
            'user_name'  => '用户名',
            'user_phone' => '登录手机号码',
            'password'   => '登录密码',
            'role_ids'   => '权限角色组',
        ];
    }
}
