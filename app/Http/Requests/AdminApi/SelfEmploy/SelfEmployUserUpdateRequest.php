<?php


namespace App\Http\Requests\AdminApi\SelfEmploy;


use App\Http\Requests\AdminApi\BaseRequest;

class SelfEmployUserUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_name' => 'bail|required|string|max:16',
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
            'user_name' => '用户名',
        ];
    }

}