<?php

class ImportIngdibaCsvTest extends ImportCsvTest
{
    public function getInput()
    {
        return "tests/Import/samples/ingdiba.csv";
    }

    public function getExpectedTransactions()
    {
        return [
            new \SebastianWalker\Statement\Transaction(
                -5,
                "PP.1234.PP . ACME LTD, Ihr Einka uf bei ACME LTD",
                "PayPal (Europe) S.a.r.l. et Cie., S.C.A.",
                null,
                new \Carbon\Carbon("2017-12-11")
            ),
            new \SebastianWalker\Statement\Transaction(
                -2,
                "PP.1234.PP . ACME LTD, Ihr Einka uf bei ACME LTD",
                "PayPal (Europe) S.a.r.l. et Cie., S.C.A.",
                null,
                new \Carbon\Carbon("2017-12-11")
            ),
            new \SebastianWalker\Statement\Transaction(
                30,
                "Auslagen",
                "MAX MUSTERMANN",
                null,
                new \Carbon\Carbon("2017-12-11")
            )
        ];
    }
}