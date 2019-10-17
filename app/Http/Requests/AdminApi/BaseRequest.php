<?php

namespace App\Http\Requests\AdminApi;

use App\Http\Requests\Request;

class BaseRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * 通用状态描述
     *
     * @return array
     */
    protected function commonAttributes()
    {
        return array_merge(parent::commonAttributes(), []);
    }
}
