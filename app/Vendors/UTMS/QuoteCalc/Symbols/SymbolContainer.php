<?php

namespace UTMS\QuoteCalc\Symbols;

use ChrisKonnertz\StringCalc\Symbols\Concrete\Brackets\ClosingBracket;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Brackets\OpeningBracket;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\MaxFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Functions\MinFunction;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Number;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\AdditionOperator;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\DivisionOperator;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\ExponentiationOperator;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\ModuloOperator;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\MultiplicationOperator;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Operators\SubtractionOperator;
use ChrisKonnertz\StringCalc\Symbols\Concrete\Separator;
use ChrisKonnertz\StringCalc\Symbols\SymbolContainer as ParentSymbolContainer;
use UTMS\Object\Quote\QueryVariables;
use UTMS\QuoteCalc\Symbols\Concrete\Constants\ChargeableWeightConstant;
use UTMS\QuoteCalc\Symbols\Concrete\Constants\CollectFeeConstant;
use UTMS\QuoteCalc\Symbols\Concrete\Constants\DeclaredValueConstant;
use UTMS\QuoteCalc\Symbols\Concrete\Constants\DynamicConstant;
use UTMS\QuoteCalc\Symbols\Concrete\Constants\FreightCollectConstant;
use UTMS\QuoteCalc\Symbols\Concrete\Constants\FreightConstant;
use UTMS\QuoteCalc\Symbols\Concrete\Constants\PieceConstant;
use UTMS\QuoteCalc\Symbols\Concrete\Constants\ReceiptCountConstant;
use UTMS\QuoteCalc\Symbols\Concrete\Constants\VolumeConstant;
use UTMS\QuoteCalc\Symbols\Concrete\Constants\WeightConstant;
use UTMS\QuoteCalc\Symbols\Concrete\Functions\ExistFunction;
use UTMS\QuoteCalc\Symbols\Concrete\Functions\HasFunction;

/**
 * The symbol container manages an array with all symbol objects.
 *
 * @package UTMS\QuoteCalc
 */
class SymbolContainer extends ParentSymbolContainer
{
    /**
     * 初始化符号
     *
     * @var array
     */
    protected $initSymbols = [
        Number::class,

        Separator::class,

        ClosingBracket::class,
        OpeningBracket::class,

        // 支持的符号
        AdditionOperator::class,
        DivisionOperator::class,
        ExponentiationOperator::class,
        ModuloOperator::class,
        MultiplicationOperator::class,
        SubtractionOperator::class,

        // 支持的函数
        MaxFunction::class,
        MinFunction::class,
        HasFunction::class,
        ExistFunction::class,

        // 支持的常量
        PieceConstant::class,
        WeightConstant::class,
        VolumeConstant::class,
        ChargeableWeightConstant::class,
        DeclaredValueConstant::class,
        FreightConstant::class,
        CollectFeeConstant::class,
        FreightCollectConstant::class,
        ReceiptCountConstant::class,
    ];

    /**
     * 动态常量符号列表
     *
     * @var \UTMS\QuoteCalc\Symbols\Concrete\Constants\DynamicConstant[]
     */
    protected $dynamicConstantSymbols = [];

    /**
     * Retrieves the list of available symbol classes,
     * creates objects of these classes and stores them.
     *
     * @return void
     */
    protected function prepare()
    {
        foreach ($this->initSymbols as $symbolClassName) {
            /** @var \ChrisKonnertz\StringCalc\Symbols\AbstractSymbol $symbol */
            $symbol = new $symbolClassName($this->stringHelper);

            // Notice: We cannot use add() here, because validation might fail
            // if we do not add the Numbers class as the first symbol.
            $this->symbols[$symbolClassName] = $symbol;

            // 动态变量单独存一个数组，方便取出赋值计算
            if ($symbol instanceof DynamicConstant) {
                try {
                    $shortName = (new \ReflectionClass($symbol))->getShortName();
                    $name      = substr($shortName, 0, -8);

                    $this->dynamicConstantSymbols[$name] = $symbol;
                } catch (\Throwable $e) {
                }
            }
        }
    }

    /**
     * 更改常量的值
     *
     * @param \UTMS\Object\Quote\QueryVariables $queryVariables
     */
    public function applyQuoteVariables(QueryVariables $queryVariables)
    {
        foreach ($this->dynamicConstantSymbols as $name => $symbol) {
            $symbol->setValue($queryVariables->{'compute' . $name});
        }
    }

    /**
     * 获取类对应符号
     *
     * @param string $className
     *
     * @return \ChrisKonnertz\StringCalc\Symbols\AbstractSymbol
     */
    public function getSymbol($className)
    {
        return $this->symbols[$className] ?? null;
    }
}