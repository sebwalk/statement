<?php

class ImportVolksbankCsvTest extends ImportCsvTest
{
    public function getInput()
    {
        return "tests/Import/samples/volksbank.csv";
    }

    public function getExpectedTransactions()
    {
        return [
            new \SebastianWalker\Statement\Transaction(
                20.9,
                "ABSCHLUSS ABSCHLUSS PER 31.12.2017",
                null,
                null,
                new \Carbon\Carbon("2017-12-29")
            ),
            new \SebastianWalker\Statement\Transaction(
                1202.1,
                "UEBERWEISUNGSGUTSCHR Auslagen Teamtag 2017 Rückz ahlung IBAN: DE893704004405 32013000 BIC: FRSPDE66 ABWA : Kreiskasse Breisgau-Hochs chwarzwald",
                "Sebastian Walker",
                "DE89370400440532013000",
                new \Carbon\Carbon("2017-12-29")
            ),
            new \SebastianWalker\Statement\Transaction(
                100,
                "SB-EINZAHLUNG Musterweg 7, Musterhausen/M usterhausen/DE 22.12.2017/23:13 girocard GA 00000000/00000000/000000 00000000/0000000000/1/0000 Karteninhaber Sebastian Wal ker",
                "GENODE61FR1",
                null,
                new \Carbon\Carbon("2017-12-27")
            ),
            new \SebastianWalker\Statement\Transaction(
                500,
                "BARAUSZAHLUNG",
                null,
                null,
                new \Carbon\Carbon("2017-12-22")
            ),
            new \SebastianWalker\Statement\Transaction(
                310,
                "UEBERWEISUNGSGUTSCHR PFIX-14567789 IBAN: DE89370 400440532013000 BIC: INGDDE FF",
                "Sebastian Walker",
                "DE89370400440532013000",
                new \Carbon\Carbon("2017-12-13")
            ),
            new \SebastianWalker\Statement\Transaction(
                1250.6,
                null,
                null,
                null,
                new \Carbon\Carbon("2017-08-22")
            ),
            new \SebastianWalker\Statement\Transaction(
                1250.62,
                null,
                null,
                null,
                new \Carbon\Carbon("2018-01-03")
            )
        ];
    }
}