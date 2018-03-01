<?php

namespace SebastianWalker\Statement\Importers;

use SebastianWalker\Statement\ColumnGuessers\ColumnGuesser;
use SebastianWalker\Statement\ColumnGuessers\DictionaryGuesser;
use SebastianWalker\Statement\Exceptions\ImportException;
use SebastianWalker\Statement\Normalizers\DefaultNormalizer;
use SebastianWalker\Statement\Normalizers\Normalizer;
use SebastianWalker\Statement\Transaction;

class FromCsv implements Importer
{
    /**
     * The input for the CSV parser (string or file path)
     *
     * @var string|null
     */
    private $input;

    /**
     * The CSV delimiter to be used, defaults to semicolon
     *
     * @var string
     */
    private $delimiter;

    /**
     * A known line offset to use, if it remains null the offset will be guessed
     *
     * @var integer|null
     */
    private $offset;

    /**
     * An array containing all parsed transactions
     *
     * @var Transaction[]
     */
    private $transactions = [];

    /**
     * Array of table column titles
     *
     * @var string[]
     */
    private $columns;

    /**
     * The minimum amount of columns in a row for it to be considered a data row (auto offset guessing)
     *
     * @var int
     */
    private $minColumns = 3;

    /**
     * The ColumnGuesser instance
     *
     * @var DictionaryGuesser
     */
    private $columnGuesser;

    /**
     * The Normalizer instance
     *
     * @var Normalizer
     */
    private $normalize;

    /**
     * FromCsv constructor.
     *
     * @param string $input
     * @param string $delimiter
     * @param array $known_mapping
     * @param null|integer $offset
     * @throws ImportException
     */
    public function __construct($input, $delimiter = ';', $known_mapping = [], $offset = null)
    {
        if(!is_readable($input)){
            throw new ImportException("The given input CSV file is not readable.");
        }

        $this->input = $input;
        $this->delimiter = $delimiter;
        $this->offset = $offset;

        $parser = $this->getParser();
        $parser->offset = $this->getOffset();
        $parser->parse($this->input);
        $this->columns = array_map("utf8_encode",$parser->titles);

        $this->columnGuesser = $this->getColumnGuesser($this->columns, $parser->data, $known_mapping);
        $this->normalize = $this->getNormalizer();

        $rows = array_filter($parser->data, function($row){
            return count($row) > $this->minColumns;
        });

        $transactions = array_map([$this, 'rowToTransaction'], $rows);

        $transactions = array_filter($transactions, function(Transaction $transaction){
            return $transaction->getAmount() !== null;
        });

        $this->transactions = array_values($transactions);
    }

    /**
     * Get all the transactions that were imported
     *
     * @return Transaction[]
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * Returns the table column titles
     *
     * @return string[]
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Returns the currently used column mapping
     *
     * @return string[]
     */
    public function getMapping()
    {
        return $this->columnGuesser->getMapping();
    }

    /**
     * Attempts to guess the start of structured data in the CSV document
     *
     * Some banks include an unstructured header part in their CSV exports, before the actual structured transaction
     * data is listed. In order to take this into account the following two conditions are applied when guessing offset:
     *
     * - There are no empty fields in the row (e.g. unstructured summary at the top with only the first column used)
     * - There are more than 3 columns in the row (e.g. unstructured summary with only one CSV field per row)
     *
     * @return int
     */
    public function guessOffset()
    {
        $parser = $this->getParser();
        $parser->heading = false;
        $parser->parse($this->input);

        foreach($parser->data as $index=>$row){
            if(array_search("", $row) === false && count($row) > $this->minColumns){
                return $index;
            }
        }

        return 0;
    }

    /**
     * Returns the offset that should be used
     *
     * @return int
     */
    private function getOffset()
    {
        if(is_integer($this->offset)){
            return $this->offset;
        }

        return $this->guessOffset();
    }

    /**
     * Converts a CSV row to a transaction
     *
     * @param array $row
     * @return Transaction
     */
    private function rowToTransaction(array $row)
    {
        $row = array_values($row);

        return new Transaction(
            $this->normalize->amount(
                $this->getFieldOfRow($row, $this->columnGuesser->getAmountIndex())
            ),
            $this->normalize->description(
                $this->getFieldOfRow($row, $this->columnGuesser->getDescriptionIndex())
            ),
            $this->normalize->payer(
                $this->getFieldOfRow($row, $this->columnGuesser->getPayerIndex())
            ),
            $this->normalize->iban(
                $this->getFieldOfRow($row, $this->columnGuesser->getIbanIndex())
            ),
            $this->normalize->date(
                $this->getFieldOfRow($row, $this->columnGuesser->getDateIndex())
            )
        );
    }

    /**
     * Returns the value of the specified key in the given row
     *
     * @param array $row
     * @param string $key
     * @return string|null
     */
    private function getFieldOfRow($row, $key)
    {
        if(isset($row[$key])){
            return $row[$key];
        }

        return null;
    }

    /**
     * Returns a parseCSV instance with basic configuration
     *
     * @return \parseCSV
     */
    private function getParser()
    {
        $parser = new \parseCSV();
        $parser->delimiter = $this->delimiter;
        $parser->convert_encoding = true;
        return $parser;
    }

    /**
     * Returns a ColumnGuesser instance
     *
     * @return ColumnGuesser
     */
    private function getColumnGuesser($headings, $data, $known_mapping)
    {
        return new DictionaryGuesser($headings, $data, $known_mapping);
    }

    /**
     * Returns a Normalizer instance
     *
     * @return Normalizer
     */
    private function getNormalizer()
    {
        return new DefaultNormalizer();
    }
}