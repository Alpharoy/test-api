<?php

namespace App\Http\Requests\AdminApi\NaturalPerson;

use App\Http\Requests\AdminApi\BaseRequest;

class NaturalPersonUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'contact_address' => 'required|string|max:64',

            'certificate_photo_front' => 'required|string|image_code',
            'certificate_photo_back'  => 'required|string|image_code',
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
            'contact_address' => '联系地址',

            'certificate_photo_front' => '证件照正面',
            'certificate_photo_back'  => '证件照背面',
        ];
    }

}