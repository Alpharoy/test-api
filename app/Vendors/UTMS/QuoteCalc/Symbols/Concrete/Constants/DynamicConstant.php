<?php

namespace UTMS\QuoteCalc\Symbols\Concrete\Constants;

use ChrisKonnertz\StringCalc\Symbols\AbstractConstant;

abstract class DynamicConstant extends AbstractConstant
{
    /**
     * 设置值
     *
     * @param mixed $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
}