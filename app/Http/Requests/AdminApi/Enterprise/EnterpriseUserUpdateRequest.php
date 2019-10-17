<?php


namespace App\Http\Requests\AdminApi\Enterprise;


use App\Http\Requests\AdminApi\BaseRequest;

class EnterpriseUserUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_name' => 'bail|required|string|max:16',
            'role_ids'  => 'nullable|array',
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
            'user_name' => '用户名',
            'role_ids'  => '权限角色组',
        ];
    }

}