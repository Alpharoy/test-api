<?php


namespace App\Http\Requests\EnterpriseApi\Project;


use App\Http\Requests\EnterpriseApi\BaseRequest;

class ProjectCreateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'supplier_uuid' => 'required|string|max:32',

            'project_name' => 'required|string|max:64',

            'charge_person_name'         => 'required|string|max:32',
            'charge_person_phone_number' => 'required|string|size:11|phone_number',

            'industry_type_code'   => 'required|string|max:32',
            'employment_type_code' => 'required|string|max:32',

            'address_code'   => 'nullable|string|max:32',
            'address_name'   => 'nullable|string|max:64',
            'address_detail' => 'nullable|string|max:255',
            'introduce'      => 'nullable|string|max:255',

            'permission' => 'nullable|ql_int:tiny',
            'is_open'    => 'required|boolean',

            'attachment'        => 'bail|nullable|array|max:5',
            'attachment.*.name' => 'required|string|max:64',
            'attachment.*.code' => 'required|string|max:32',
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
            'supplier_uuid' => '供应商',

            'project_name' => '项目名称',

            'charge_person_name'         => '负责人姓名',
            'charge_person_phone_number' => '负责人手机',

            'industry_type_code'   => '行业类型编码',
            'employment_type_code' => '用工类型编码',

            'address_code'   => '项目地区编码',
            'address_name'   => '项目地区名称',
            'address_detail' => '项目详细地址',
            'introduce'      => '详细描述',

            'permission' => '权限',
            'is_open'    => '是否启用',

            'attachment'        => '附件文件',
            'attachment.*.name' => '附件文件名',
            'attachment.*.code' => '附件code',
        ];
    }


}