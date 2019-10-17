<?php

namespace App\Http\Requests\AdminApi\Permission;

use App\Http\Requests\AdminApi\BaseRequest;

class MenuCreateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'parent_id'   => 'nullable|int',
            'name'        => 'required|string|max:32',
            'description' => 'nullable|string|max:128',
            'group'       => 'required|ql_int:tiny',
            'allow_nodes' => '',
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
            'parent_id'   => '父菜单ID',
            'name'        => '菜单名称',
            'description' => '菜单简介',
            'group'       => '菜单所属',
            'allow_nodes' => '允许的权限列表',
        ];
    }
}
