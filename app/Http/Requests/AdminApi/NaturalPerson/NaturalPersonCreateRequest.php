<?php


namespace App\Http\Requests\AdminApi\NaturalPerson;


use App\Http\Requests\AdminApi\BaseRequest;

class NaturalPersonCreateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_name'  => 'required|string|max:32',
            'user_phone' => 'required|string|size:11|phone_number',

            'id_card_number'  => 'required|string|size:18|id_card',
            'contact_address' => 'required|string|max:255',

            'certificate_photo_front' => 'required|string|image_code',
            'certificate_photo_back'  => 'required|string|image_code',

            'password' => 'required|string|min:6|max:32',
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
            'user_name'  => '用户姓名',
            'user_phone' => '用户手机号',

            'id_card_number' => '身份证号码',

            'contact_address' => '联系地址',

            'certificate_photo_front' => '证件照正面',
            'certificate_photo_back'  => '证件照背面',

            'password' => '登录密码',
        ];
    }

}