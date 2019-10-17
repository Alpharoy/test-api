<?php


namespace App\Http\Requests\SupplierApi\Auth;


use App\Http\Requests\SupplierApi\BaseRequest;
use UTMS\Validator\LuhnVerify;

class RegisterSupplierRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'supplier_name' => 'required|string|max:64',

            'industry_type_code' => 'nullable|string|max:32',
            'location_code'      => 'nullable|string|max:32',

            'usci_number' => 'required|string|max:64',

            'artificial_person_name'                  => 'required|string|max:32',
            'artificial_person_phone_number'          => 'nullable|string|size:11|phone_number',
            'artificial_person_certificate_type_code' => 'nullable|string|max:32',
            'artificial_person_certificate_number'    => 'nullable|string|max:32',

            'email' => 'nullable|string|max:64',

            'business_license_photo' => 'required|string|image_code',
            'business_scope'         => 'nullable|string|max:64',
            'business_address'       => 'nullable|string|max:32',

            'telephone'            => 'nullable|string|max:16',
            'contact_name'         => 'required|string|max:32',
            'contact_phone_number' => 'required|string|size:11|phone_number',
            'introduce'            => 'nullable|string|max:255',

            'tax_identification_number'  => 'required|string|max:64',
            'invoice_title'              => 'required|string|max:64',
            'bank_name'                  => 'required|string|max:32',
            'bank_account'               => [
                'required',
                'string',
                'max:20',
                function ($attribute, $value, $fail) {
                    if (!LuhnVerify::validateBankCardNo($value)) {
                        //return $fail('不是有效的银行卡卡号');
                    }
                },
            ],
            'bank_reserve_mobile_number' => 'required|string|size:11|phone_number',
            'invoice_address'            => 'required|string|max:255',
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
            'supplier_name' => '供应商名称',

            'industry_type_code' => '行业类型编码',
            'location_code'      => '所在区域编码',

            'usci_number' => '统一信用代码',

            'artificial_person_name'                  => '法人姓名',
            'artificial_person_phone_number'          => '法人手机号码',
            'artificial_person_certificate_type_code' => '法人证件类型编码',
            'artificial_person_certificate_number'    => '法人证件号码',

            'business_license_photo' => '营业执照照片',
            'business_scope'         => '经营范围',
            'business_address'       => '经营地址',

            'telephone'            => '企业电话',
            'contact_name'         => '联系人姓名',
            'contact_phone_number' => '联系人手机号码',
            'introduce'            => '企业介绍',

            'tax_identification_number'  => '纳税人识别号',
            'invoice_title'              => '发票抬头',
            'bank_name'                  => '银行名称',
            'bank_account'               => '银行账号',
            'bank_reserve_mobile_number' => '银行预留手机号码',
            'invoice_address'            => '发票单位地址',
        ];
    }
}