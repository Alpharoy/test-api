<?php

namespace App\Http\Requests\AdminApi\Enterprise;

use App\Http\Requests\AdminApi\BaseRequest;
use UTMS\Validator\LuhnVerify;

class EnterpriseCreateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'enterprise' => 'required|array',

            'enterprise.enterprise_name' => 'required|string|max:64',

            'enterprise.industry_type_code' => 'nullable|string|max:32',
            'enterprise.location_code'      => 'nullable|string|max:32',

            'enterprise.usci_number' => 'required|string|max:64',

            'enterprise.artificial_person_name'                  => 'required|string|max:32',
            'enterprise.artificial_person_phone_number'          => 'nullable|string|size:11|phone_number',
            'enterprise.artificial_person_certificate_type_code' => 'nullable|string|max:32',
            'enterprise.artificial_person_certificate_number'    => 'nullable|string|max:32',

            'enterprise.business_license_photo' => 'required|string|image_code',
            'enterprise.business_scope'         => 'nullable|string|max:64',
            'enterprise.business_address'       => 'nullable|string|max:32',

            'enterprise.email'                => 'nullable|string|max:64',
            'enterprise.telephone'            => 'nullable|string|max:16',
            'enterprise.contact_name'         => 'required|string|max:32',
            'enterprise.contact_phone_number' => 'required|string|size:11|phone_number',
            'enterprise.introduce'            => 'nullable|string|max:255',

            'enterprise.tax_identification_number'  => 'required|string|max:64',
            'enterprise.invoice_title'              => 'required|string|max:64',
            'enterprise.bank_name'                  => 'required|string|max:32',
            'enterprise.bank_reserve_mobile_number' => 'required|string|size:11|phone_number',
            'enterprise.bank_account'               => [
                'required',
                'string',
                'max:20',
                function ($attribute, $value, $fail) {
//                    if (!LuhnVerify::validateBankCardNo($value)) {
//                        return $fail('不是有效的银行卡卡号');
//                    }
                },
            ],
            'enterprise.invoice_address'            => 'required|string|max:255',

            'user'            => 'required|array',
            'user.user_phone' => 'required|string|size:11|phone_number',
            'user.user_name'  => 'required|string|max:10',
            'user.password'   => 'required|string|min:6|max:32',
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
            'enterprise' => '企业信息',

            'enterprise.enterprise_name' => '企业名称',

            'enterprise.industry_type_code' => '行业类型编码',
            'enterprise.location_code'      => '所在区域编码',

            'enterprise.usci_number' => '统一信用代码',

            'enterprise.artificial_person_name'                  => '法人姓名',
            'enterprise.artificial_person_phone_number'          => '法人手机号码',
            'enterprise.artificial_person_certificate_type_code' => '法人证件类型编码',
            'enterprise.artificial_person_certificate_number'    => '法人证件号码',

            'enterprise.business_license_photo' => '营业执照照片',
            'enterprise.business_scope'         => '经营范围',
            'enterprise.business_address'       => '经营地址',

            'enterprise.email'                => '公司邮箱',
            'enterprise.telephone'            => '企业电话',
            'enterprise.contact_name'         => '联系人姓名',
            'enterprise.contact_phone_number' => '联系人手机号码',
            'enterprise.introduce'            => '企业介绍',

            'enterprise.tax_identification_number'  => '纳税人识别号',
            'enterprise.invoice_title'              => '发票抬头',
            'enterprise.bank_name'                  => '银行名称',
            'enterprise.bank_account'               => '银行账号',
            'enterprise.bank_reserve_mobile_number' => '银行预留手机号码',
            'enterprise.invoice_address'            => '发票单位地址',

            'user'            => '公司管理员信息',
            'user.user_phone' => '管理员账号',
            'user.user_name'  => '管理员名字',
            'user.password'   => '管理员密码',
        ];
    }
}
