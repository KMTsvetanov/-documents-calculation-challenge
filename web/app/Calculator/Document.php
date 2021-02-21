<?php


namespace App\Calculator;


use App\Exceptions\ValidationException;

/**
 * Class Document
 * @package App\Calculator
 */
class Document
{
    const INVOICE = 1;
    const CREDIT = 2;
    const DEBIT = 3;

    /**
     * @var string
     */
    private string $customer;
    /**
     * @var string
     */
    private string $vatNumber;
    /**
     * @var string
     */
    private string $documentNumber;
    /**
     * @var string
     */
    private string $type;
    /**
     * @var string
     */
    private string $parentDocument;
    /**
     * @var string
     */
    private string $currency;
    /**
     * @var string
     */
    private string $total;

    /**
     * Document constructor.
     * @param $record
     * @throws ValidationException
     */
    public function __construct($record)
    {
        $this->validation($record);
    }

    /**
     * @param $record
     * @throws ValidationException
     */
    private function validation($record)
    {
        if (!$this->arrayRecordKeysExists([
            'Customer',
            'Vat number',
            'Document number',
            'Type',
            'Parent document',
            'Currency',
            'Total',
        ], $record)) {
            throw new ValidationException('Missing Document params!');
        };

        if (strlen($record['Customer']) == 0) {
            throw new ValidationException('Document param "Customer" is empty!');
        }

        $filter_options = array(
            'options' => array('min_range' => 0)
        );
        if (!filter_var($record['Vat number'], FILTER_VALIDATE_INT, $filter_options)) {
            throw new ValidationException('Document param "Vat number" is not a positive integer!');
        }

        if (!filter_var($record['Document number'], FILTER_VALIDATE_INT, $filter_options)) {
            throw new ValidationException('Document param "Document number" is not a positive integer!');
        }

        switch ($record['Type']) {
            case self::INVOICE :
            case self::CREDIT :
            case self::DEBIT :
                break;
            default:
                throw new ValidationException('Document param "Type" is not one of the allowed!');

        }

        if ($record['Parent document'] != '' && !filter_var($record['Parent document'], FILTER_VALIDATE_INT, $filter_options)) {
            throw new ValidationException('Document param "Parent document" is not one of the allowed!');
        }

        $record['Currency'] = str_replace(' ', '', $record['Currency']);
        if (strlen($record['Currency']) !== 3 || mb_strtoupper($record['Currency'], 'utf-8') !== $record['Currency']) {
            throw new ValidationException('Document param "Currency" is not one of the allowed!');
        }

        if (!filter_var($record['Total'], FILTER_VALIDATE_INT, $filter_options)) {
            throw new ValidationException('Document param "Total" is not a positive integer!');
        }

        $this->setCustomer($record['Customer']);
        $this->setVatNumber($record['Vat number']);
        $this->setDocumentNumber($record['Document number']);
        $this->setType($record['Type']);
        $this->setParentDocument($record['Parent document']);
        $this->setCurrency($record['Currency']);
        $this->setTotal($record['Total']);
    }

    /**
     * @param array $keys
     * @param array $arr
     * @return bool
     */
    private function arrayRecordKeysExists(array $keys, array $arr)
    {
        return !array_diff_key(array_flip($keys), $arr);
    }

    /**
     * @return string
     */
    public function getCustomer(): string
    {
        return $this->customer;
    }

    /**
     * @param string string
     */
    public function setCustomer(string $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return string
     */
    public function getVatNumber(): string
    {
        return $this->vatNumber;
    }

    /**
     * @param string $vatNumber
     */
    public function setVatNumber(string $vatNumber): void
    {
        $this->vatNumber = $vatNumber;
    }

    /**
     * @return string
     */
    public function getDocumentNumber(): string
    {
        return $this->documentNumber;
    }

    /**
     * @param string $documentNumber
     */
    public function setDocumentNumber(string $documentNumber): void
    {
        $this->documentNumber = $documentNumber;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getParentDocument(): string
    {
        return $this->parentDocument;
    }

    /**
     * @param string $parentDocument
     */
    public function setParentDocument(string $parentDocument): void
    {
        $this->parentDocument = $parentDocument;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getTotal(): string
    {
        return $this->total;
    }

    /**
     * @param string $total
     */
    public function setTotal(string $total): void
    {
        $this->total = $total;
    }
}