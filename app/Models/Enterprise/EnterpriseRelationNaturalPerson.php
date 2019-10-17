<?php


namespace App\Models\Enterprise;


use App\Models\Model;
use App\Models\NaturalPerson\NaturalPerson;

class EnterpriseRelationNaturalPerson extends Model
{

    protected $table = 'enterprise_relation_natural_person';

    /**
     * model名称
     *
     * @var string
     */
    const MODEL_NAME = '企业关联自然人';

    /**
     * 可以被批量赋值的字段
     *
     * @var array
     */
    protected $fillable = [
        'enterprise_uuid',
        'enterprise_name',
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