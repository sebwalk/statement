<?php

class ImportArrayTest extends \PHPUnit\Framework\TestCase
{
    public function sampleTransactions()
    {
        return [
            new \SebastianWalker\Statement\Transaction(
                10,
                "Transaction No 1"
            ),
            new \SebastianWalker\Statement\Transaction(
                -10,
                "Transaction No 2",
                "Sebastian Walker",
                "DE89370400440532013000",
                (new \Carbon\Carbon("2018-02-12"))->startOfDay()
            )
        ];
    }

    public function testImportsArrayCorrectly()
    {
        $importer = new \SebastianWalker\Statement\Importers\FromArray($this->sampleTransactions());
        $transactions = $importer->getTransactions();

        $this->assertEquals($this->sampleTransactions(), $transactions);
    }
}