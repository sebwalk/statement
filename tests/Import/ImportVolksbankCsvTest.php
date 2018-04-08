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
                "ABSCHLUSSABSCHLUSS PER 31.12.2017",
                null,
                null,
                new \Carbon\Carbon("2017-12-29")
            ),
            new \SebastianWalker\Statement\Transaction(
                1202.1,
                "UEBERWEISUNGSGUTSCHRAuslagen Teamtag 2017 Rückzahlung IBAN: DE89370400440532013000 BIC: FRSPDE66 ABWA: Kreiskasse Breisgau-Hochschwarzwald",
                "Sebastian Walker",
                "DE89 3704 0044 0532 0130 00",
                new \Carbon\Carbon("2017-12-29")
            ),
            new \SebastianWalker\Statement\Transaction(
                100,
                "SB-EINZAHLUNGMusterweg 7, Musterhausen/Musterhausen/DE22.12.2017/23:13 girocardGA 00000000/00000000/00000000000000/0000000000/1/0000Karteninhaber Sebastian Walker",
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
                "UEBERWEISUNGSGUTSCHRPFIX-14567789 IBAN: DE89370400440532013000 BIC: INGDDEFF",
                "Sebastian Walker",
                "DE89 3704 0044 0532 0130 00",
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