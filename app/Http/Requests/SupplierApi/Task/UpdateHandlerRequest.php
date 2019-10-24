<?php

namespace App\Http\Requests\SupplierApi\Task;

use App\Http\Requests\SupplierApi\BaseRequest;

class UpdateHandlerRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'handler_object_group'       => 'required|ql_int:tiny',
            'handler_object_uuid'        => 'required|string|max:32',
            'handler_object_card_number' => 'nullable|string|max:32',
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
            'handler_object_group'       => '接单人类型',
            'handler_object_uuid'        => '接单人',
            'handler_object_card_number' => '接单人银行卡号',
        ];
    }


}