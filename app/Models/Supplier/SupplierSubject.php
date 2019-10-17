<?php

namespace App\Models\Supplier;

use App\Models\Model;
use Carbon\Carbon;
use UTMS\UUID\UUID;

class SupplierSubject extends Model
{
    protected $table = 'supplier_subjects';

    /**
     * model名称
     *
     * @var string
     */
    const MODEL_NAME = '供应商业务类型';

    /**
     * 可以被批量赋值的字段
     *
     * @var array
     */
    protected $fillable = [
        'supplier_uuid',
        'supplier_subject_uuid',
        'supplier_subject_name',
        'industry_type_code',
        'industry_type_name',
        'introduce',
        'is_open',
    ];

    /**
     * 返回该字段自动设置未 Carbon 对象
     *
     * @var array
     */
    protected $dates = [

    ];

    /**
     * 应该被转换成原生类型的属性
     *
     * @var array
     */
    protected $casts = [
        'is_open' => 'bool',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (SupplierSubject $supplierSubject) {
            //先设置删除标志,等待UUID填充后，清除删除标志
            $supplierSubject->setAttribute('delete_time', Carbon::now());
        });

        static::created(function (SupplierSubject $supplierSubject) {
            $supplierSubject->syncOriginal();
            $UUID = UUID::buildById(cons('uuid.supplier_subject'), $supplierSubject->id);
            $data = [
                'supplier_subject_uuid' => $UUID,
                'delete_time'           => null,
            ];
            $supplierSubject->forceFill($data)->save();
        });
    }
}