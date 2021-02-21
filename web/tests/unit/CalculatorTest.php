<?php

use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    /** @test */
    public function set_documents_returns_error_if_not_array_of_document_passed()
    {
        $this->expectException(\App\Exceptions\ValidationException::class);
        $documents = \App\Calculator\CsvHandler::createFromPath(__DIR__ . '/../../public/file/data.csv', 'r');
        $calculator = new \App\Calculator\Calculator();
        $calculator->setDocuments(array_merge($documents, ['not Document']));
    }

    /** @test */
    public function set_and_get_right_validated_documents()
    {
        $documents = \App\Calculator\CsvHandler::createFromPath(__DIR__ . '/../../public/file/data.csv', 'r');
        $calculator = new \App\Calculator\Calculator();
        $calculator->setDocuments($documents);

        $data = $calculator->getDocuments();

        $this->assertCount(count($documents), $data);
        $this->assertEquals($documents[0]->getCustomer(), $data[0]->getCustomer());
        $this->assertEquals($documents[0]->getVatNumber(), $data[0]->getVatNumber());
        $this->assertEquals($documents[0]->getDocumentNumber(), $data[0]->getDocumentNumber());
        $this->assertEquals($documents[0]->getType(), $data[0]->getType());
        $this->assertEquals($documents[0]->getParentDocument(), $data[0]->getParentDocument());
        $this->assertEquals($documents[0]->getCurrency(), $data[0]->getCurrency());
        $this->assertEquals($documents[0]->getTotal(), $data[0]->getTotal());
    }

    /** @test */
    public function set_currencies_and_output_currency()
    {
        $calculator = new \App\Calculator\Calculator();

        $calculator->setCurrencies([
            new \App\Calculator\Currency('EUR', 1),
            new \App\Calculator\Currency('USD', 0.987),
            new \App\Calculator\Currency('GBP', 0.878),
        ]);

        $this->assertCount(3, $calculator->getCurrencies());
        $this->assertEquals('EUR', $calculator->getCurrencies()[0]->getIso());
        $this->assertEquals(1, $calculator->getCurrencies()[0]->getRate());
        $this->assertEquals('EUR', $calculator->getOutputCurrency()->getIso());
        $this->assertEquals(1, $calculator->getOutputCurrency()->getRate());
    }

    /** @test */
    public function return_decimal_returns_error_of_it_is_not_positive_integer()
    {
        $this->expectException(\App\Exceptions\ValidationException::class);

        (new \App\Calculator\Calculator())->setDecimals(-2);
    }

    /** @test */
    public function return_decimal_must_be_a_positive_integer()
    {
        $calculator = new \App\Calculator\Calculator();
        $calculator->setDecimals(2);

        $this->assertEquals(2, $calculator->getDecimals());
    }

    /** @test */
    public function calculate_total_return_error_if_no_currencies_set()
    {
        $this->expectException(\App\Exceptions\ValidationException::class);

        (new \App\Calculator\Calculator())->getTotals();
    }

    /** @test */
    public function calculate_total_return_error_if_document_has_currency_that_is_not_set_in_the_calculator()
    {
        $this->expectException(\App\Exceptions\ValidationException::class);

        $documents = \App\Calculator\CsvHandler::createFromPath(__DIR__ . '/../../public/file/data.csv', 'r');
        $calculator = new \App\Calculator\Calculator();
        $calculator->setDocuments($documents);
        $calculator->setCurrencies([
            new \App\Calculator\Currency('EUR', 1),
            new \App\Calculator\Currency('USD', 0.987),
        ]);
        $asd = $calculator->getTotals(
//    $vat = '123456789'
        );
        var_dump($asd);die;
    }

    /** @test */
    public function calculate_total_without_vat()
    {
        $documents = \App\Calculator\CsvHandler::createFromPath(__DIR__ . '/../../public/file/data.csv', 'r');
        $calculator = new \App\Calculator\Calculator();
        $calculator->setDocuments($documents);
        $calculator->setCurrencies([
            new \App\Calculator\Currency('EUR', 1),
            new \App\Calculator\Currency('USD', 0.987),
            new \App\Calculator\Currency('GBP', 0.878),
        ]);
        $total = $calculator->getTotals();

        $this->assertEquals('3,882.7 EUR', $total);
    }

    /** @test */
    public function calculate_total_with_vat()
    {
        $documents = \App\Calculator\CsvHandler::createFromPath(__DIR__ . '/../../public/file/data.csv', 'r');
        $calculator = new \App\Calculator\Calculator();
        $calculator->setDocuments($documents);
        $calculator->setCurrencies([
            new \App\Calculator\Currency('EUR', 1),
            new \App\Calculator\Currency('USD', 0.987),
            new \App\Calculator\Currency('GBP', 0.878),
        ]);
        $total = $calculator->getTotals('123456789');

        $this->assertEquals('Customer Vendor 1 - 1,938.7 EUR', $total);
    }
}