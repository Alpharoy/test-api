<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Urland\Api\Http\Requests\ApiRequest;

abstract class Request extends ApiRequest
{
    /**
     * 日期格式
     *
     * @var string
     */
    protected $dateTimeFormat = DATE_RFC3339;

    /**
     * 日期时间校验规则，用于判断字段是否日期
     *
     * @var string
     */
    protected $dateTimeRule = 'date_format:' . DATE_RFC3339;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * 通用状态描述
     *
     * @return array
     */
    protected function commonAttributes()
    {
        return [];
    }

    /**
     * 获取日期格式的输入
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return \Carbon\Carbon|mixed
     * @throws \InvalidArgumentException
     */
    public function inputDateTime($key, $default = null)
    {
        $dateTime = $this->input($key);
        if (is_null($dateTime)) {
            return $default;
        }

        return Carbon::createFromFormat($this->dateTimeFormat, $dateTime);
    }

    /**
     * 某日期的 00:00:00
     *
     * @param string $key
     * @param null   $default
     *
     * @return Carbon|mixed|static
     */
    public function inputDateTimeOfStart($key, $default = null)
    {
        $dateTime = $this->inputDateTime($key, $default);
        if ($dateTime instanceof Carbon) {
            return $dateTime->startOfDay();
        }
        return $dateTime;
    }

    /**
     * 某日期的 23:59:59
     *
     * @param string $key
     * @param null   $default
     *
     * @return Carbon|mixed|static
     */
    public function inputDateTimeOfEnd($key, $default = null)
    {
        $dateTime = $this->inputDateTime($key, $default);
        if ($dateTime instanceof Carbon) {
            return $dateTime->endOfDay();
        }
        return $dateTime;
    }

    /**
     * Get the validated data from the request.
     *
     * @return array
     */
    public function validated()
    {
        $rules = $this->container->call([$this, 'rules']);

        // 转成N维数组并且判断是否是日期规则
        $validatedKeys = [];
        foreach ($rules as $key => $rule) {
            Arr::set($validatedKeys, $key, $this->hasDateTimeRule($rule));
        }

        return $this->validatedArray($validatedKeys, $this->all());
    }

    /**
     * 过滤未设置规则的字段
     *
     * @param array $arrayKeys
     * @param array $arrayData
     *
     * @return array
     */
    private function validatedArray($arrayKeys, $arrayData)
    {
        if (!Arr::accessible($arrayKeys) || !Arr::accessible($arrayData)) {
            return null;
        }

        $validated = [];
        foreach ($arrayKeys as $key => $hasDateTimeRule) {
            if (is_array($hasDateTimeRule)) {
                $subArrayKeys = $hasDateTimeRule;
                $subArrayData = Arr::get($arrayData, $key, []);

                reset($subArrayKeys);
                if (key($subArrayKeys) === '*') {
                    // 如果子集第一个key是*，则进行foreach遍历子集过滤
                    $subValidated    = [];
                    $subSubArrayKeys = $subArrayKeys['*'];
                    foreach ($subArrayData as $subSubArrayData) {
                        $subValidated[] = $this->validatedArray($subSubArrayKeys, $subSubArrayData);
                    }
                    $validated[$key] = $subValidated;
                } else {
                    // 否则遍历后赋值
                    $validated[$key] = $this->validatedArray($subArrayKeys, $subArrayData);
                }
            } elseif (is_bool($hasDateTimeRule)) {
                // 直接赋值，并且转换为日期格式
                $value           = $arrayData[$key] ?? null;
                $validated[$key] = $hasDateTimeRule && $value ? $this->convertValueToCarbon($value) : $value;
            }
        }

        return $validated;
    }

    /**
     * 检查是否为日期字段
     *
     * @param string|array $rules
     *
     * @return bool
     */
    private function hasDateTimeRule($rules)
    {
        $dateTimeRule = $this->dateTimeRule;
        foreach ((array)$rules as $rule) {
            if (is_string($rule) && mb_strpos($rule, $dateTimeRule) !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * 将值转换为日期
     *
     * @param string $value
     *
     * @return \Carbon\Carbon|null
     */
    private function convertValueToCarbon($value)
    {
        try {
            // 替换日期字段内容为日期对象
            return Carbon::createFromFormat($this->dateTimeFormat, $value);
        } catch (\Exception $e) {
        }
        return null;
    }
}
