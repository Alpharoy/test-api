<?php


namespace App\Models\Supplier;


use App\Models\Model;
use App\Models\SelfEmploy\SelfEmploy;

class SupplierRelationSelfEmploy extends Model
{
    protected $table = 'supplier_relation_self_employ';

    /**
     * model名称
     *
     * @var string
     */
    const MODEL_NAME = '供应商关联个体';

    /**
     * 可以被批量赋值的字段
     *
     * @var array
     */
    protected $fillable = [
        'supplier_uuid',
        'supplier_name',
        'self_employ_uuid',
        'self_employ_name'
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
     * 定义和个体户的关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function selfEmploy()
    {
        return $this->belongsTo(SelfEmploy::class, 'self_employ_uuid', 'self_employ_uuid');
    }

}