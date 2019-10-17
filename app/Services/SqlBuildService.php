<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Arr;

/**
 * Class SqlBuildService
 *
 * @package App\Services
 */
class SqlBuildService extends BaseService
{
    /**
     * 建立like搜索查询
     *
     * @param        $sqlQuery
     * @param        $request
     * @param array  $parameterNames
     * @param string $relationship 模型关联里搜索
     *
     * @return mixed
     */
    public static function buildLikeQuery($sqlQuery, $request = [], $parameterNames = [], $relationship = '')
    {
        foreach ($parameterNames as $sqlField => $parameterName) {
            $searchValue = Arr::get($request, $parameterName, null);
            if (!is_null($searchValue)) {
                if (empty($relationship)) {
                    $sqlQuery->where($sqlField, 'like', '%' . $searchValue . '%');
                } else {
                    $sqlQuery->whereHas($relationship, function ($relationshipQuery) use ($sqlField, $searchValue) {
                        $relationshipQuery->where($sqlField, 'like', '%' . $searchValue . '%');
                    });
                }
            }
        }
        return $sqlQuery;
    }

    /**
     * 建立相等搜索查询
     *
     * @param        $sqlQuery
     * @param array  $request
     * @param array  $parameterNames
     * @param string $relationship 模型关联里搜索
     *
     * @return mixed
     */
    public static function buildEqualQuery($sqlQuery, $request = [], $parameterNames = [], $relationship = '')
    {
        foreach ($parameterNames as $sqlField => $parameterName) {
            $searchValue = Arr::get($request, $parameterName, null);
            if (!is_null($searchValue)) {
                if (empty($relationship)) {
                    $sqlQuery->where($sqlField, $searchValue);
                } else {
                    $sqlQuery->whereHas($relationship, function ($relationshipQuery) use ($sqlField, $searchValue) {
                        $relationshipQuery->where($sqlField, $searchValue);
                    });
                }
            }
        }
        return $sqlQuery;
    }

    /**
     * 建立时间区间搜索查询
     *
     * @param        $sqlQuery
     * @param array  $request
     * @param string $sqlField            搜索的数据库字段
     * @param string $parameterNamePrefix 搜索参数前缀，统一用 xxx_start, xxx_end 做时间区间搜索
     * @param string $relationship        模型关联里搜索
     *
     * @return mixed
     */
    public static function buildTimeQuery(
        $sqlQuery,
        $request = [],
        $sqlField = 'create_time',
        $parameterNamePrefix = 'create_time',
        $relationship = ''
    ) {
        // 开始时间搜索
        $searchTimeStart = Arr::get($request, $parameterNamePrefix . '_start', null);
        if (!is_null($searchTimeStart)) {
            $searchTimeStart = Carbon::createFromFormat(DATE_RFC3339, $searchTimeStart)->startOfDay();
            if (empty($relationship)) {
                $sqlQuery->where($sqlField, '>=', $searchTimeStart);
            } else {
                $sqlQuery->whereHas($relationship, function ($relationshipQuery) use ($sqlField, $searchTimeStart) {
                    $relationshipQuery->where($sqlField, '>=', $searchTimeStart);
                });
            }
        }

        // 结束时间搜索
        $searchTimeEnd = Arr::get($request, $parameterNamePrefix . '_end', null);
        if (!is_null($searchTimeEnd)) {
            $searchTimeEnd = Carbon::createFromFormat(DATE_RFC3339, $searchTimeEnd)->endOfDay();
            if (empty($relationship)) {
                $sqlQuery->where($sqlField, '<=', $searchTimeEnd);
            } else {
                $sqlQuery->whereHas($relationship, function ($relationshipQuery) use ($sqlField, $searchTimeEnd) {
                    $relationshipQuery->where($sqlField, '<=', $searchTimeEnd);
                });
            }
        }

        return $sqlQuery;
    }
}