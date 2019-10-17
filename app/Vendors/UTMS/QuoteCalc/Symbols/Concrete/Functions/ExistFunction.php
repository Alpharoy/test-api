<?php

namespace UTMS\QuoteCalc\Symbols\Concrete\Functions;

use ChrisKonnertz\StringCalc\Exceptions\NumberOfArgumentsException;
use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;

/**
 * Example: "e(0,10+1)" => 0, "e(-1,10+2)" => 0, "e(5,10+3)" => 13
 *
 * @see http://php.net/manual/en/ref.math.php
 */
class ExistFunction extends AbstractFunction
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['e', 'exist'];

    /**
     * @inheritdoc
     */
    public function execute(array $arguments)
    {
        if (sizeof($arguments) !== 2) {
            throw new NumberOfArgumentsException('Error: Expected two argument');
        }

        $condition = $arguments[0];
        $result    = $arguments[1];

        return $condition > 0 ? $result : 0;
    }

}