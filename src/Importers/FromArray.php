<?php

namespace SebastianWalker\Statement\Importers;

use SebastianWalker\Statement\Transaction;

class FromArray implements Importer
{
    /**
     * @var Transaction[]
     */
    private $transactions = [];

    /**
     * FromArray constructor.
     * @param Transaction[] $transactions
     */
    public function __construct(array $transactions)
    {
        $this->transactions = $transactions;
    }

    /**
     * Get all the transactions that were imported
     *
     * @return Transaction[]
     */
    public function getTransactions()
    {
        return $this->transactions;
    }
}