<?php

namespace SebastianWalker\Statement\Importers;

use SebastianWalker\Statement\Transaction;

interface Importer
{
    /**
     * Get all the transactions that were imported by the respective importer
     *
     * @return Transaction[]
     */
    public function getTransactions();
}