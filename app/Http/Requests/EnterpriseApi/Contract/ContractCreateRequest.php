<?php


namespace App\Http\Requests\EnterpriseApi\Contract;


use App\Http\Requests\EnterpriseApi\BaseRequest;

class ContractCreateRequest extends BaseRequest
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

            'contract_no'   => 'required|string|max:32',
            'contract_name' => 'required|string|max:32',

            'applicant_name'    => 'required|string|max:32',
            'valid_time'        => 'required|' . $this->dateTimeRule,
            'introduce'         => 'nullable|string|max:255',
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

            'contract_no'   => '合同编码',
            'contract_name' => '合同名称',

            'applicant_name' => '申请人姓名',
            'valid_time'     => '合约有效期',
            'introduce'      => '合约描述',

            'attachment'        => '附件文件',
            'attachment.*.name' => '附件文件名',
            'attachment.*.code' => '附件code',
        ];
    }
}