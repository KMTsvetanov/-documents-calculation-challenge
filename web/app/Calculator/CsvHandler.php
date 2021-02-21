<?php


namespace App\Calculator;


use App\Exceptions\ValidationException;
use League\Csv\Reader;

/**
 * Class CsvHandler
 * @package App\Calculator
 */
class CsvHandler
{
    /**
     * @param string $path
     * @param string $openMode
     * @return array
     * @throws ValidationException
     * @throws \League\Csv\Exception
     */
    public static function createFromPath(string $path, string $openMode = 'r'): array
    {
        if (!file_exists($path)) {
            throw new ValidationException('File doesn\'t exist!');
        }
        $data = [];

        $csv = Reader::createFromPath($path, $openMode);
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();

        foreach ($records as $record) {
            $data[] = new Document($record);
        };

        return $data;
    }
}