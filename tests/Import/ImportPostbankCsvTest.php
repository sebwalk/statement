<?php

class ImportPostbankCsvTest extends ImportCsvTest
{
    public function getInput()
    {
        return "tests/Import/samples/postbank.csv";
    }

    public function getExpectedTransactions()
    {
        return [
            new \SebastianWalker\Statement\Transaction(
                51.2,
                "Rueckzahlung Auslagen 2019",
                "Max Mustermann",
                null,
                new \Carbon\Carbon("2018-02-12")
            ),
            new \SebastianWalker\Statement\Transaction(
                80,
                "Test Einzahlung",
                "Max Mustermann",
                null,
                new \Carbon\Carbon("2018-01-25")
            ),
            new \SebastianWalker\Statement\Transaction(
                -5.7,
                null,
                "Sebastian Walker",
                null,
                new \Carbon\Carbon("2017-12-29")
            )
        ];
    }
}