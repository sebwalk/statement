<?php

class ImportSparkasseCsvTest extends ImportCsvTest
{
    public function getInput()
    {
        return "tests/Import/samples/sparkasse.csv";
    }

    public function getExpectedTransactions()
    {
        return [
            new \SebastianWalker\Statement\Transaction(
                -100,
                "EC XXXXXXXX XXXXXXXXXXXXXX",
                "",
                null,
                new \Carbon\Carbon("2018-02-26")
            ),
            new \SebastianWalker\Statement\Transaction(
                -20,
                "Aufladung POS FR",
                "Studierendenwerk Freiburg",
                "DE89370400440532013000",
                new \Carbon\Carbon("2018-02-22")
            ),
            new \SebastianWalker\Statement\Transaction(
                -1234.56,
                "Test �berweisung DATUM 25.02.2018, 20.09 UHR1.TAN 639600",
                "Sebastian Walker",
                "DE89370400440532013000",
                new \Carbon\Carbon("2018-02-26")
            ),
            new \SebastianWalker\Statement\Transaction(
                1234.56,
                "Test �berweisung",
                "SEBASTIAN WALKER",
                "DE89370400440532013000",
                new \Carbon\Carbon("2018-02-26")
            ),
            new \SebastianWalker\Statement\Transaction(
                -24,
                "PP.1234.PP . ACME LTD, Ihr Einkauf bei ACME LTD",
                "PayPal (Europe) S.a.r.l. et Cie., S.C.A.",
                "DE89370400440532013000",
                new \Carbon\Carbon("2018-02-23")
            ),
            new \SebastianWalker\Statement\Transaction(
                58.34,
                "STRIPE ABCDEF AWV-MELDEPFLICHT BEACHTEN HOTLINE BUNDESBANK (0800) 1234-111",
                "Stripe Payments UK Ltd 9th Floor, 107 Cheapside, GB - London EC2V 6DN",
                "DE89370400440532013000",
                new \Carbon\Carbon("2018-02-15")
            )
        ];
    }
}