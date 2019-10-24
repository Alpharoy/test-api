<?php

namespace App\Http\Requests\EnterpriseApi\Task;

use App\Http\Requests\EnterpriseApi\BaseRequest;

class TaskCreateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'task_name' => 'required|string|max:64',

            'address_code'   => 'required|string|max:32',
            'address_detail' => 'required|string|max:64',

            'contact_name'         => 'required|string|max:32',
            'contact_phone_number' => 'required|size:11|phone_number',

            'introduce' => 'required|string|max:1024',

            'start_time' => 'required|' . $this->dateTimeRule,
            'end_time'   => 'required|' . $this->dateTimeRule,

            'project_uuid'          => 'required|string|max:32',
            'supplier_subject_uuid' => 'required|string|max:32',

            'handler_object_group'       => 'required|ql_int:tiny',
            'handler_object_uuid'        => 'required|string|max:32',
            'handler_object_card_number' => 'nullable|string|max:32',

            'task_fees' => 'required|ql_int:big',

            'pictures' => 'bail|nullable|array|max:3',

            'attachment'        => 'bail|nullable|array|max:3',
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
            'task_name' => '任务名称',

            'address_code'   => '任务地址编码',
            'address_detail' => '任务地址详情',

            'contact_name'         => '联系人',
            'contact_phone_number' => '联系方式',

            'introduce' => '任务描述',

            'start_time' => '开始时间',
            'end_time'   => '结束时间',

            'project_uuid'          => '项目',
            'supplier_subject_uuid' => '科目',

            'handler_object_group'       => '接单人类型',
            'handler_object_uuid'        => '接单人',
            'handler_object_card_number' => '接单人银行卡号',

            'task_fees' => '订单费用',

            'pictures' => '图片',

            'attachment'        => '附件文件',
            'attachment.*.name' => '附件文件名',
            'attachment.*.code' => '附件code',
        ];
    }


}