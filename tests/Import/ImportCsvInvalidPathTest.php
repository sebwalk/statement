<?php

class ImportCsvInvalidPathTest extends \PHPUnit\Framework\TestCase
{
    public function testImportsCsvCorrectly()
    {
        $this->expectException(\SebastianWalker\Statement\Exceptions\ImportException::class);

        new \SebastianWalker\Statement\Importers\FromCsv("this is not a file path");
    }
}