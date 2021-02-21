<?php


namespace App\Calculator;


/**
 * Class CalculatorReturn
 * @package App\Calculator
 */
class CalculatorReturn
{
    /**
     * @param $sum
     * @param $decimal
     * @param $decimalSeparator
     * @param $thousandsSeparator
     * @param $iso
     * @param null $customer
     * @return string
     */
    public static function returnSum($sum, $decimal, $decimalSeparator, $thousandsSeparator, $iso, $customer = null): string
    {
        $prefix = !is_null($customer) ? 'Customer ' . $customer . ' - ' : '';
        $returnSum = number_format(
            $sum,
            $decimal,
            $decimalSeparator,
            $thousandsSeparator
        );
        $suffix = ' ' . $iso;

        return $prefix . $returnSum . $suffix;
    }
}