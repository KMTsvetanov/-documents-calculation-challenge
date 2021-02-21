<?php

use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{
    /** @test */
    public function iso_must_be_3_letter()
    {
        $this->expectException(\App\Exceptions\ValidationException::class);

        (new \App\Calculator\Currency('eur', 1));
    }

    /** @test */
    public function iso_must_be_caps_only()
    {
        $this->expectException(\App\Exceptions\ValidationException::class);

        (new \App\Calculator\Currency('eur', 1));
    }

    /** @test */
    public function rate_must_have_max_three_decimals()
    {
        $this->expectException(\App\Exceptions\ValidationException::class);

        (new \App\Calculator\Currency('EUR', 0.0001));
    }

    /** @test */
    public function iso_and_rate_return_the_same_that_are_set()
    {
        $currency = new \App\Calculator\Currency('EUR', 1);

        $this->assertEquals('EUR', $currency->getIso());
        $this->assertEquals(1, $currency->getRate());
    }

    /** @test */
    public function set_decimal_separator()
    {
        $currency = new \App\Calculator\Currency('EUR', 1);

        $currency->setDecimalSeparator('.');
        $this->assertEquals('.' , $currency->getDecimalSeparator());
    }

    /** @test */
    public function set_thousands_separator()
    {
        $currency = new \App\Calculator\Currency('EUR', 1);

        $currency->setThousandsSeparator(',');
        $this->assertEquals(',' , $currency->getThousandsSeparator());
    }
}