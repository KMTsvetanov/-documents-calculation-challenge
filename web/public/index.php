<?php

use App\Calculator\Calculator;
use App\Calculator\CsvHandler;
use App\Calculator\Currency;

require '../vendor/autoload.php';

try {
    $documents = CsvHandler::createFromPath(__DIR__ . '/file/data.csv', 'r');
    $calculator = new Calculator();
    $calculator
        ->setDocuments($documents)
        ->setCurrencies([
            (new Currency('EUR', 1))->setDecimalSeparator('.')->setThousandsSeparator(','),
            new Currency('USD', 0.987),
            new Currency('GBP', 0.878),
        ])
        ->setDecimals(2);

    echo $calculator->getTotals('123456789');
} catch (\App\Exceptions\ValidationException $e) {
    echo $e->getMessage();
}

?>
