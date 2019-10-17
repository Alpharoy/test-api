<?php

namespace App\Http\Requests\SupplierApi\Supplier\SupplierSubject;

use App\Http\Requests\SupplierApi\BaseRequest;

class SupplierSubjectCreateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'industry_type_code'    => 'required|string|max:32',
            'supplier_subject_name' => 'required|string|max:32',
            'introduce'             => 'nullable|string|max:255',
            'is_open'               => 'required|boolean',
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
            'industry_type_code'    => '行业类型',
            'supplier_subject_name' => '科目名称',
            'introduce'             => '科目描述',
            'is_open'               => '是否启用',
        ];
    }

}