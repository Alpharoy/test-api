<?php

namespace App\Http\Requests\AdminApi\Admin;

use App\Http\Requests\AdminApi\BaseRequest;

class AdminUserLockRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'lock_reason' => 'required|string|max:250',
            'lock_day'    => 'required|ql_int|between:1,9999',
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
            'lock_reason' => '禁用原因',
            'lock_day'    => '禁用天数',
        ];
    }
}
