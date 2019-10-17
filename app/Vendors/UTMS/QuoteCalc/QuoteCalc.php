<?php

namespace UTMS\QuoteCalc;

use ChrisKonnertz\StringCalc\StringCalc as ParentStringCalc;
use UTMS\Object\Quote\QueryVariables;

class QuoteCalc extends ParentStringCalc
{
    /**
     * 应用符号常量值
     *
     * @param QueryVariables $queryVariables
     *
     * @return $this
     */
    public function applyQuoteVariables(QueryVariables $queryVariables)
    {
        $this->symbolContainer->applyQuoteVariables($queryVariables);

        return $this;
    }
}