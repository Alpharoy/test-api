<?php

namespace App\Http\Requests\AdminApi\Permission;

use App\Http\Requests\AdminApi\BaseRequest;

class RoleCreateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required|string|max:32',
            'description' => 'nullable|string|max:255',
            'group'       => 'required|ql_int:tiny',
            'menu_ids'    => 'array',
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
            'name'        => '角色名称',
            'description' => '角色简介',
            'group'       => '角色所属',
            'menu_ids'    => '菜单值列表',
        ];
    }
}
