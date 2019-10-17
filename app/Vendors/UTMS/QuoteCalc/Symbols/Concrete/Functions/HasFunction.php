<?php

namespace UTMS\QuoteCalc\Symbols\Concrete\Functions;

use ChrisKonnertz\StringCalc\Exceptions\NumberOfArgumentsException;
use ChrisKonnertz\StringCalc\Symbols\AbstractFunction;

/**
 * Example: "has(0)" => 0, "has(-5)" => 0, "has(5)" => 1
 *
 * @see http://php.net/manual/en/ref.math.php
 */
class HasFunction extends AbstractFunction
{

    /**
     * @inheritdoc
     */
    protected $identifiers = ['has'];

    /**
     * @inheritdoc
     */
    public function execute(array $arguments)
    {
        if (sizeof($arguments) !== 1) {
            throw new NumberOfArgumentsException('Error: Expected one argument');
        }

        return $arguments[0] > 0 ? 1 : 0;
    }

}