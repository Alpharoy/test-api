<?php

namespace App\Models\Supplier;

use App\Models\Model;
use App\Models\NaturalPerson\NaturalPerson;

class SupplierRelationNaturalPerson extends Model
{
    protected $table = 'supplier_relation_natural_person';

    /**
     * model名称
     *
     * @var string
     */
    const MODEL_NAME = '供应商关联自然人';

    /**
     * 可以被批量赋值的字段
     *
     * @var array
     */
    protected $fillable = [
        'supplier_uuid',
        'supplier_name',
        'user_uuid',
    ];

    /**
     * 返回该字段自动设置未 Carbon 对象
     *
     * @var array
     */
    protected $dates = [
        'last_modified_time',
    ];


    /**
     * 定义和自然人的关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function naturalPerson()
    {
        return $this->belongsTo(NaturalPerson::class, 'user_uuid', 'user_uuid');
    }
}