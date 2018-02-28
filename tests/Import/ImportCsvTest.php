<?php

abstract class ImportCsvTest extends \PHPUnit\Framework\TestCase
{
    public function testImportsCsvCorrectly()
    {
        $importer = new \SebastianWalker\Statement\Importers\FromCsv($this->getInput());
        $transactions = $importer->getTransactions();

        $this->assertEquals($this->getExpectedTransactions(), $transactions);
    }

    abstract function getInput();

    abstract function getExpectedTransactions();
}