<?php

namespace App\Http\Requests\SupplierApi\Supplier\SupplierSubject;

use App\Http\Requests\SupplierApi\BaseRequest;

class SupplierSubjectUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'introduce' => 'nullable|string|max:255',
            'is_open'   => 'required|boolean',
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
            'introduce' => '科目描述',
            'is_open'   => '是否启用',
        ];
    }

}