<?php

use PHPUnit\Framework\TestCase;

class DocumentTest extends TestCase
{
    /** @test */
    public function missing_values_will_throw_an_error()
    {
        $this->expectException(\App\Exceptions\ValidationException::class);

        $value = [
//            'Customer' => 'Vendor 1',
            'Vat number' => '123456789',
            'Document number' => '1000000257',
            'Type' => '1',
            'Parent document' => '',
            'Currency' => 'USD',
            'Total' => '400',
        ];

        (new \App\Calculator\Document($value));
    }

    /** @test */
    public function customer_validation()
    {
        $this->expectException(\App\Exceptions\ValidationException::class);

        $value = [
            'Customer' => '',
            'Vat number' => '123456789',
            'Document number' => '1000000257',
            'Type' => '1',
            'Parent document' => '',
            'Currency' => 'USD',
            'Total' => '400',
        ];

        (new \App\Calculator\Document($value));
    }

    /** @test */
    public function vat_number_validation()
    {
        $this->expectException(\App\Exceptions\ValidationException::class);

        $value = [
            'Customer' => 'Vendor 1',
            'Vat number' => '-123456789',
            'Document number' => '1000000257',
            'Type' => '1',
            'Parent document' => '',
            'Currency' => 'USD',
            'Total' => '400',
        ];

        (new \App\Calculator\Document($value));
    }

    /** @test */
    public function document_number_validation()
    {
        $this->expectException(\App\Exceptions\ValidationException::class);

        $value = [
            'Customer' => 'Vendor 1',
            'Vat number' => '123456789',
            'Document number' => '-1000000257',
            'Type' => '1',
            'Parent document' => '',
            'Currency' => 'USD',
            'Total' => '400',
        ];

        (new \App\Calculator\Document($value));
    }

    /** @test */
    public function type_validation()
    {
        $this->expectException(\App\Exceptions\ValidationException::class);

        $value = [
            'Customer' => 'Vendor 1',
            'Vat number' => '123456789',
            'Document number' => '1000000257',
            'Type' => '4',
            'Parent document' => '',
            'Currency' => 'USD',
            'Total' => '400',
        ];

        (new \App\Calculator\Document($value));
    }

    /** @test */
    public function parent_document_validation()
    {
        $this->expectException(\App\Exceptions\ValidationException::class);

        $value = [
            'Customer' => 'Vendor 1',
            'Vat number' => '123456789',
            'Document number' => '1000000257',
            'Type' => '3',
            'Parent document' => 'Parent document',
            'Currency' => 'USD',
            'Total' => '400',
        ];

        (new \App\Calculator\Document($value));
    }

    /** @test */
    public function currency_validation()
    {
        $this->expectException(\App\Exceptions\ValidationException::class);

        $value = [
            'Customer' => 'Vendor 1',
            'Vat number' => '123456789',
            'Document number' => '1000000257',
            'Type' => '3',
            'Parent document' => '',
            'Currency' => 'Dolar',
            'Total' => '400',
        ];

        (new \App\Calculator\Document($value));
    }

    /** @test */
    public function total_validation()
    {
        $this->expectException(\App\Exceptions\ValidationException::class);

        $value = [
            'Customer' => 'Vendor 1',
            'Vat number' => '123456789',
            'Document number' => '1000000257',
            'Type' => '3',
            'Parent document' => '',
            'Currency' => 'USD',
            'Total' => '-400',
        ];

        (new \App\Calculator\Document($value));
    }
}