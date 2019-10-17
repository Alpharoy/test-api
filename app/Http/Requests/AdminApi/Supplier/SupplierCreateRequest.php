<?php


namespace App\Http\Requests\AdminApi\Supplier;


use App\Http\Requests\AdminApi\BaseRequest;
use UTMS\Validator\LuhnVerify;

class SupplierCreateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'supplier' => 'required|array',

            'supplier.supplier_name' => 'required|string|max:64',

            'supplier.industry_type_code' => 'nullable|string|max:32',
            'supplier.location_code'      => 'nullable|string|max:32',

            'supplier.usci_number' => 'required|string|max:64',

            'supplier.artificial_person_name'                  => 'required|string|max:32',
            'supplier.artificial_person_phone_number'          => 'nullable|string|size:11|phone_number',
            'supplier.artificial_person_certificate_type_code' => 'nullable|string|max:32',
            'supplier.artificial_person_certificate_number'    => 'nullable|string|max:32',

            'supplier.business_license_photo' => 'required|string|image_code',
            'supplier.business_scope'         => 'nullable|string|max:64',
            'supplier.business_address'       => 'nullable|string|max:32',

            'supplier.email'                => 'nullable|string|max:64',
            'supplier.telephone'            => 'nullable|string|max:16',
            'supplier.contact_name'         => 'required|string|max:32',
            'supplier.contact_phone_number' => 'required|string|size:11|phone_number',
            'supplier.introduce'            => 'nullable|string|max:255',

            'supplier.tax_identification_number'  => 'required|string|max:64',
            'supplier.invoice_title'              => 'required|string|max:64',
            'supplier.bank_name'                  => 'required|string|max:32',
            'supplier.bank_reserve_mobile_number' => 'required|string|size:11|phone_number',
            'supplier.bank_account'               => [
                'required',
                'string',
                'max:20',
                function ($attribute, $value, $fail) {
//                    if (!LuhnVerify::validateBankCardNo($value)) {
//                        return $fail('不是有效的银行卡卡号');
//                    }
                },
            ],
            'supplier.invoice_address'            => 'required|string|max:255',

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
            'supplier' => '企业信息',

            'supplier.supplier_name' => '企业名称',

            'supplier.industry_type_code' => '行业类型编码',
            'supplier.location_code'      => '所在区域编码',

            'supplier.usci_number' => '统一信用代码',

            'supplier.artificial_person_name'                  => '法人姓名',
            'supplier.artificial_person_phone_number'          => '法人手机号码',
            'supplier.artificial_person_certificate_type_code' => '法人证件类型编码',
            'supplier.artificial_person_certificate_number'    => '法人证件号码',

            'supplier.business_license_photo' => '营业执照照片',
            'supplier.business_scope'         => '经营范围',
            'supplier.business_address'       => '经营地址',

            'supplier.email'                => '公司邮箱',
            'supplier.telephone'            => '企业电话',
            'supplier.contact_name'         => '联系人姓名',
            'supplier.contact_phone_number' => '联系人手机号码',
            'supplier.introduce'            => '企业介绍',

            'supplier.tax_identification_number'  => '纳税人识别号',
            'supplier.invoice_title'              => '发票抬头',
            'supplier.bank_name'                  => '银行名称',
            'supplier.bank_account'               => '银行账号',
            'supplier.bank_reserve_mobile_number' => '银行预留手机号码',
            'supplier.invoice_address'            => '发票单位地址',

            'user'            => '公司管理员信息',
            'user.user_phone' => '管理员账号',
            'user.user_name'  => '管理员名字',
            'user.password'   => '管理员密码',
        ];
    }
}
