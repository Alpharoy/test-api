<?php

namespace UTMS\QuoteCalc\Container\ServiceProviders;

use ChrisKonnertz\StringCalc\Container\AbstractSingletonServiceProvider;
use UTMS\QuoteCalc\Symbols\SymbolContainer;

/**
 * This is a service provider class for the symbol container class.
 *
 * @package ChrisKonnertz\QuoteCalc\Container\ServiceProviders
 */
class SymbolContainerServiceProvider extends AbstractSingletonServiceProvider
{

    /**
     * @inheritdoc
     */
    protected function createService()
    {
        $stringHelper = $this->getService('stringcalc_stringhelper');

        return new SymbolContainer($stringHelper);
    }

}
