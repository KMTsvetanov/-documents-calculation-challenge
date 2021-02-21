<?php


namespace App\Calculator;


use App\Exceptions\ValidationException;

/**
 * Class Calculator
 * @package App\Calculator
 */
class Calculator
{
    /**
     * @var array
     */
    protected array $currencies = [];
    /**
     * @var int
     */
    protected int $decimals = 1;
    /**
     * @var array
     */
    protected array $documents = [];
    /**
     * @var Currency
     */
    protected Currency $outputCurrency;

    /**
     * @param $decimals
     * @return $this
     * @throws ValidationException
     */
    public function setDecimals($decimals): self
    {
        $filter_options = array(
            'options' => array('min_range' => 0)
        );

        if (!filter_var($decimals, FILTER_VALIDATE_INT, $filter_options)) {
            throw new ValidationException('Calculator decimal is not a positive integer!');
        }

        $this->decimals = $decimals;

        return $this;
    }


    /**
     * @return int
     */
    public function getDecimals(): int
    {
        return $this->decimals;
    }

    /**
     * @param array $currencies
     * @return $this
     */
    public function setCurrencies(array $currencies): self
    {
        $this->outputCurrency = $currencies[0];
        $this->currencies = $currencies;

        return $this;
    }

    /**
     * @return array
     */
    public function getCurrencies(): array
    {
        return $this->currencies;
    }

    /**
     * @param string $vat
     * @return string
     * @throws ValidationException
     */
    public function getTotals($vat = ''): string
    {
        if (empty($this->getCurrencies())) {
            throw new ValidationException('No Currencies set!');
        }
        $tmp = [];
        $customer = null;
        foreach ($this->getCurrencies() as $currency) {
            $tmp[$currency->getIso()] = $currency->getRate();
        }

        $sum = 0;
        foreach ($this->getDocuments() as $document) {
            /** @var Document $document */
            if (!array_key_exists($document->getCurrency(), $tmp)) {
                throw new ValidationException('Document with currency ' . $document->getCurrency() . ' that is not set in the calculator!');
            }
            if ($vat != '' && $document->getVatNumber() != $vat) {
                continue;
            }
            if ($vat != '' && is_null($customer)) {
                $customer = $document->getCustomer();
            }

            if ($document->getType() != Document::CREDIT) {
                $sum = bcadd($sum, bcmul($document->getTotal(), $tmp[$document->getCurrency()], 6), 6);
            } else {
                $sum = bcsub($sum, bcmul($document->getTotal(), $tmp[$document->getCurrency()], 6), 6);
            }
        }

        return CalculatorReturn::returnSum(
            $sum,
            $this->getDecimals(),
            $this->getOutputCurrency()->getDecimalSeparator(),
            $this->getOutputCurrency()->getThousandsSeparator(),
            $this->getOutputCurrency()->getIso(),
            $customer
        );
    }

    /**
     * @param array $documents
     * @return $this
     * @throws ValidationException
     */
    public function setDocuments(array $documents): self
    {
        if (empty($documents)) {
            throw new ValidationException('No documents set!');
        }

        foreach ($documents as $document) {
            if (!$document instanceof Document) {
                throw new ValidationException('Can only set objects instance of Documents!');
            }
        }

        $this->documents = $documents;

        return $this;
    }

    /**
     * @return array
     */
    public function getDocuments(): array
    {
        return $this->documents;
    }

    /**
     * @return Currency
     */
    public function getOutputCurrency(): Currency
    {
        return $this->outputCurrency;
    }

}