<?php
namespace SebastianWalker\Statement\Matchers;

use SebastianWalker\Statement\Transaction;

interface Matcher
{
    /**
     * Get all entities that this transaction matches.
     *
     * @param Transaction $transaction
     * @return mixed[]
     */
    public function getEntities(Transaction $transaction);
}