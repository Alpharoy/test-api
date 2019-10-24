<?php

namespace App\Services\Supplier;

use App\Events\Supplier\SupplierSubjectUpdateEvent;
use App\Models\Project\Project;
use App\Models\Supplier\SupplierSubject;
use App\Services\BaseService;
use Urland\Exceptions\Client\ForbiddenException;
use Urland\Exceptions\Client\NotFoundException;

class SupplierSubjectService extends BaseService
{
    /**
     * 新建科目
     *
     * @param string $supplierUUID
     * @param array  $supplierSubjectData
     *
     * @return \App\Models\Supplier\SupplierSubject|\Illuminate\Database\Eloquent\Model
     */
    public static function store($supplierUUID, $supplierSubjectData = [])
    {
        $supplierSubjectData['supplier_uuid'] = $supplierUUID;

        $supplierSubjectData = self::fillData($supplierSubjectData);
        $supplierSubject     = SupplierSubject::create($supplierSubjectData);

        return $supplierSubject;
    }

    /**
     * 编辑科目
     *
     * @param \App\Models\Supplier\SupplierSubject $supplierSubject
     * @param array                                $supplierSubjectData
     *
     * @return \App\Models\Supplier\SupplierSubject
     */
    public static function update(SupplierSubject $supplierSubject, $supplierSubjectData = [])
    {
        $supplierSubjectData = self::fillData($supplierSubjectData, $supplierSubject);
        $supplierSubject->fill($supplierSubjectData)->save();

        // 抛出科目更新事件
        event(new SupplierSubjectUpdateEvent($supplierSubject));
        return $supplierSubject;
    }

    /**
     * 填充科目字段
     *
     * @param array                                     $supplierSubjectData
     * @param \App\Models\Supplier\SupplierSubject|null $originData
     *
     * @return array
     */
    protected static function fillData($supplierSubjectData = [], SupplierSubject $originData = null)
    {
        $originArray = [];
        if (!is_null($originData)) {
            $originArray = $originData->toArray();
        }
        $supplierSubjectData = array_merge($originArray, $supplierSubjectData);

        // 检查名称唯一
        $query = SupplierSubject::query();
        $query->where('supplier_uuid', $supplierSubjectData['supplier_uuid']);
        $query->where('industry_type_code', $supplierSubjectData['industry_type_code']);
        $query->where('supplier_subject_name', $supplierSubjectData['supplier_subject_name']);
        if (!is_null($originData)) {
            $query->where('id', '<>', $originData->id);
        }
        $exists = $query->exists();
        if ($exists) {
            throw new ForbiddenException('已有相同的科目名称');
        }

        // 填充行业类型名称
        if (is_null($originData) || $originData->industry_type_code != $supplierSubjectData['industry_type_code']) {
            $industryType = app('file-db')->load('industry_types')->firstWhere('code',
                $supplierSubjectData['industry_type_code']);
            if (!$industryType) {
                throw new NotFoundException('行业类型选择错误');
            }
            $supplierSubjectData['industry_type_code'] = $industryType['code'];
            $supplierSubjectData['industry_type_name'] = $industryType['name'];
        }

        return $supplierSubjectData;
    }

    /**
     * 科目的启用状态同步回项目的科目启用状态
     *
     * @param \App\Models\Supplier\SupplierSubject $supplierSubject
     *
     * @return bool
     */
    public static function openStatusEffect(SupplierSubject $supplierSubject)
    {
        $exists = SupplierSubject::where('supplier_uuid', $supplierSubject->supplier_uuid)->where('industry_type_code',
            $supplierSubject->industry_type_code)->where('is_open', true)->exists();

        // 有一个科目被启用，则项目都被启用
        // 全部都被禁用，则项目都被禁用
        Project::where('supplier_uuid', $supplierSubject->supplier_uuid)->where('industry_type_code',
            $supplierSubject->industry_type_code)->where('is_industry_type_open',
            !$exists)->update(['is_industry_type_open' => $exists]);
        return true;
    }
}