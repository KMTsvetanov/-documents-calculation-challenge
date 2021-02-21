<?php

use PHPUnit\Framework\TestCase;

class CsvHandletTest extends TestCase
{
    /** @test */
    public function file_that_does_not_exist_returns_error()
    {
        $this->expectException(\App\Exceptions\ValidationException::class);

        \App\Calculator\CsvHandler::createFromPath(__DIR__ . '/../../public/file/dataNew.csv', 'r');
    }

    /** @test */
    public function return_array_with_element_for_each_row()
    {
        /** @var \App\Calculator\Document $documents[0] */
        $documents = \App\Calculator\CsvHandler::createFromPath(__DIR__ . '/../../public/file/data.csv', 'r');
        $this->assertCount(8, $documents);
        $this->assertObjectHasAttribute('customer', $documents[0]);
        $this->assertObjectHasAttribute('vatNumber', $documents[0]);
        $this->assertObjectHasAttribute('documentNumber', $documents[0]);
        $this->assertObjectHasAttribute('type', $documents[0]);
        $this->assertObjectHasAttribute('parentDocument', $documents[0]);
        $this->assertObjectHasAttribute('currency', $documents[0]);
        $this->assertObjectHasAttribute('total', $documents[0]);
        $this->assertEquals('Vendor 1', $documents[0]->getCustomer());
        $this->assertEquals('123456789', $documents[0]->getVatNumber());
        $this->assertEquals('1000000257', $documents[0]->getDocumentNumber());
        $this->assertEquals('1', $documents[0]->getType());
        $this->assertEquals('', $documents[0]->getParentDocument());
        $this->assertEquals('USD', $documents[0]->getCurrency());
        $this->assertEquals('400', $documents[0]->getTotal());
    }
}