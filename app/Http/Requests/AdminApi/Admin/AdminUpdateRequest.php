<?php

namespace App\Http\Requests\AdminApi\Admin;

use App\Http\Requests\AdminApi\BaseRequest;

class AdminUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'admin_name' => 'bail|required|string|max:32',
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
            'admin_name' => '管理公司名称',
        ];
    }
}
