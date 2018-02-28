<?php
namespace SebastianWalker\Statement;

use Carbon\Carbon;

class Transaction
{
    /**
     * The transaction amount (unsigned in some bank exports)
     *
     * @var float|null
     */
    private $amount;

    /**
     * The transaction description
     *
     * @var string|null
     */
    private $description;

    /**
     * The transaction payer name
     *
     * @var string|null
     */
    private $payer;

    /**
     * The transaction payer's IBAN
     *
     * @var string|null
     */
    private $iban;

    /**
     * The transaction's valuta date
     *
     * @var Carbon|null
     */
    private $date;

    /**
     * Transaction constructor.
     * @param float $amount
     * @param string $description
     * @param null|string $payer
     * @param null|string $iban
     * @param null|Carbon $date
     */
    public function __construct($amount, $description, $payer = null, $iban = null, $date = null)
    {
        $this->amount = $amount;
        $this->description = $description;
        $this->payer = $payer;
        $this->iban = $iban;
        $this->date = $date;
    }

    /**
     * Returns the transaction amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Returns the transaction description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Returns the payer name
     *
     * @return string
     */
    public function getPayer()
    {
        return $this->payer;
    }

    /**
     * Returns the payer IBAN
     *
     * @return string
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * Returns the valuta date
     *
     * @return Carbon
     */
    public function getDate()
    {
        return $this->date;
    }
}