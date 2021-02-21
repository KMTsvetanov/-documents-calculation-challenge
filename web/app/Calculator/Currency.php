<?php


namespace App\Calculator;


use App\Exceptions\ValidationException;

/**
 * Class Currency
 * @package App\Calculator
 */
class Currency
{
    /**
     * @var string
     */
    private string $iso;
    /**
     * @var float
     */
    private float $rate;

    /**
     * @var string
     */
    private string $decimalSeparator = '.';
    /**
     * @var string
     */
    private string $thousandsSeparator = ',';

    /**
     * Currency constructor.
     * @param string $iso
     * @param float $rate
     * @throws ValidationException
     */
    public function __construct(string $iso, float $rate)
    {
        $this->setIso($iso)->setRate($rate);
    }

    /**
     * @return string
     */
    public function getIso(): string
    {
        return $this->iso;
    }

    /**
     * @param string $iso
     * @return Currency
     * @throws ValidationException
     */
    public function setIso(string $iso): self
    {
        $iso = str_replace(' ', '', $iso);
        if (strlen($iso) !== 3 || mb_strtoupper($iso, 'utf-8') !== $iso) {
            throw new ValidationException('Currency ISO validation fail!');
        }

        $this->iso = $iso;

        return $this;
    }

    /**
     * @return float
     */
    public function getRate(): float
    {
        return $this->rate;
    }

    /**
     * @param float $rate
     * @return Currency
     * @throws ValidationException
     */
    public function setRate(float $rate): self
    {
        if (strlen(strrchr($rate, '.')) > 4) {
            throw new ValidationException('Currency Rate validation fail!');
        }

        $this->rate = $rate;

        return $this;
    }

    /**
     * @return string
     */
    public function getDecimalSeparator(): string
    {
        return $this->decimalSeparator;
    }

    /**
     * @param string $decimalSeparator
     * @return $this
     */
    public function setDecimalSeparator(string $decimalSeparator): Currency
    {
        $this->decimalSeparator = $decimalSeparator;

        return $this;
    }

    /**
     * @return string
     */
    public function getThousandsSeparator(): string
    {
        return $this->thousandsSeparator;
    }

    /**
     * @param string $thousandsSeparator
     * @return Currency
     */
    public function setThousandsSeparator(string $thousandsSeparator): Currency
    {
        $this->thousandsSeparator = $thousandsSeparator;

        return $this;
    }
}