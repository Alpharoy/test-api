<?php


namespace App\Http\Requests\AdminApi\selfEmploy;


use App\Http\Requests\AdminApi\BaseRequest;
use UTMS\Validator\LuhnVerify;

class selfEmployCreateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'self_employ' => 'required|array',

            'self_employ.self_employ_name' => 'required|string|max:64',

            'self_employ.industry_type_code' => 'nullable|string|max:32',
            'self_employ.location_code'      => 'nullable|string|max:32',

            'self_employ.usci_number' => 'required|string|max:64',

            'self_employ.artificial_person_name'                  => 'required|string|max:32',
            'self_employ.artificial_person_phone_number'          => 'nullable|string|size:11|phone_number',
            'self_employ.artificial_person_certificate_type_code' => 'nullable|string|max:32',
            'self_employ.artificial_person_certificate_number'    => 'nullable|string|max:32',

            'self_employ.business_license_photo' => 'required|string|image_code',
            'self_employ.business_scope'         => 'nullable|string|max:64',
            'self_employ.business_address'       => 'nullable|string|max:32',

            'self_employ.email'                => 'nullable|string|max:64',
            'self_employ.telephone'            => 'nullable|string|max:16',
            'self_employ.contact_name'         => 'required|string|max:32',
            'self_employ.contact_phone_number' => 'required|string|size:11|phone_number',
            'self_employ.introduce'            => 'nullable|string|max:255',

            'self_employ.tax_identification_number'  => 'required|string|max:64',
            'self_employ.invoice_title'              => 'required|string|max:64',
            'self_employ.bank_name'                  => 'required|string|max:32',
            'self_employ.bank_reserve_mobile_number' => 'required|string|size:11|phone_number',
            'self_employ.bank_account'               => [
                'required',
                'string',
                'max:20',
//                function ($attribute, $value, $fail) {
//                    if (!LuhnVerify::validateBankCardNo($value)) {
//                        return $fail('不是有效的银行卡卡号');
//                    }
//                },
            ],
            'self_employ.invoice_address'            => 'required|string|max:255',

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
            'self_employ' => '工商户信息',

            'self_employ.self_employ_name' => '企业名称',

            'self_employ.industry_type_code' => '行业类型编码',
            'self_employ.location_code'      => '所在区域编码',

            'self_employ.usci_number' => '统一信用代码',

            'self_employ.artificial_person_name'                  => '法人姓名',
            'self_employ.artificial_person_phone_number'          => '法人手机号码',
            'self_employ.artificial_person_certificate_type_code' => '法人证件类型编码',
            'self_employ.artificial_person_certificate_number'    => '法人证件号码',

            'self_employ.business_license_photo' => '营业执照照片',
            'self_employ.business_scope'         => '经营范围',
            'self_employ.business_address'       => '经营地址',

            'self_employ.email'                => '公司邮箱',
            'self_employ.telephone'            => '企业电话',
            'self_employ.contact_name'         => '联系人姓名',
            'self_employ.contact_phone_number' => '联系人手机号码',
            'self_employ.introduce'            => '企业介绍',

            'self_employ.tax_identification_number'  => '纳税人识别号',
            'self_employ.invoice_title'              => '发票抬头',
            'self_employ.bank_name'                  => '银行名称',
            'self_employ.bank_account'               => '银行账号',
            'self_employ.bank_reserve_mobile_number' => '银行预留手机号码',
            'self_employ.invoice_address'            => '发票单位地址',

            'user'            => '公司管理员信息',
            'user.user_phone' => '管理员账号',
            'user.user_name'  => '管理员名字',
            'user.password'   => '管理员密码',
        ];
    }

}