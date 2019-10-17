<?php

namespace App\Http\Requests\AdminApi\Permission;

use App\Http\Requests\AdminApi\BaseRequest;

class MenuUpdateRequest extends BaseRequest
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
            'description' => 'nullable|string|max:128',
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
            'name'        => '菜单名称',
            'description' => '菜单简介',
            'allow_nodes' => '允许的权限列表',
        ];
    }
}
