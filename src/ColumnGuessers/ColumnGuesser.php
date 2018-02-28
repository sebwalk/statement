<?php
namespace SebastianWalker\Statement\ColumnGuessers;


interface ColumnGuesser
{
    /**
     * ColumnGuesser constructor.
     *
     * @param string[] $headings An 1d array of CSV headings
     * @param array[] $data A 2d array of all CSV data
     * @param string[] $known_mapping Optional 2d array of already know column mappings
     */
    public function __construct($headings, $data, $known_mapping = []);

    /**
     * Get the complete guessed column mapping
     * KEYS: type (iban, amount, etc.)
     * VALUES: column title
     *
     * @return string[]
     */
    public function getMapping();

    /**
     * Get the index of the amount column
     *
     * @return int|null
     */
    public function getAmountIndex();

    /**
     * Get the index of the description column
     *
     * @return int|null
     */
    public function getDescriptionIndex();

    /**
     * Get the index of the payer column
     *
     * @return int|null
     */
    public function getPayerIndex();

    /**
     * Get the index of the iban column
     *
     * @return int|null
     */
    public function getIbanIndex();

    /**
     * Get the index of the date column
     *
     * @return int|null
     */
    public function getDateIndex();
}