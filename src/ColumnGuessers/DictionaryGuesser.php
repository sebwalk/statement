<?php
namespace SebastianWalker\Statement\ColumnGuessers;

use CMPayments\IBAN;

class DictionaryGuesser implements ColumnGuesser
{
    /**
     * Keywords that indicate the amount column
     *
     * @var string[]
     */
    private $amountKeywords = [
        "Betrag",
        "Umsatz"
    ];

    /**
     * Keywords that indicate the description column
     *
     * @var string[]
     */
    private $descriptionKeywords = [
        "Verwendungszweck",
        "Buchungsdetails",
        "Vorgang/Verwendungszweck"
    ];

    /**
     * Keywords that indicate the payer column
     *
     * @var string[]
     */
    private $payerKeywords = [
        "Beguenstigter/Zahlungspflichtiger",
        "Auftraggeber/Empf_nger",
        "Auftraggeber",
        "Empfänger",
        "Empfï¿½nger/Zahlungspflichtiger",
        "Auftraggeber/Zahlungsempfï¿½nger",
    ];

    /**
     * Keywords that indicate the iban column
     *
     * @var string[]
     */
    private $ibanKeywords = [
        "IBAN",
        "Kontonummer",
        "Kontonummer/IBAN"
    ];

    /**
     * Keywords that indicate the date column
     *
     * @var string[]
     */
    private $dateKeywords = [
        "Datum",
        "Valuta",
        "Valutadatum",
        "Wertstellung",
        "Buchungstag",
    ];

    /**
     * All possible fields of the mapping
     *
     * @var array
     */
    private $mapable = ["amount", "description", "payer", "iban", "date"];

    /**
     * The current mapping
     *
     * @var string[]
     */
    private $mapping = [];

    /**
     * The headings of the CSV file
     *
     * @var string[]
     */
    private $headings = [];

    /**
     * DictionaryGuesser constructor.
     *
     * @param string[] $headings An 1d array of CSV headings
     * @param array[] $data A 2d array of all CSV data
     * @param string[] $known_mapping Optional 2d array of already know column mappings
     */
    public function __construct($headings, $data, $known_mapping = [])
    {
        $this->mapping = $known_mapping;
        $this->headings = $headings;

        $iban_guess = $this->guessIbanField($data);
        if($iban_guess){
            $this->mapping["iban"] = $iban_guess;
        }

        foreach($this->mapable as $key){
            if( ! isset($this->mapping[$key])){

                foreach($headings as $heading){

                    $search = trim(
                        preg_replace("/\([^)]+\)/","",$heading)
                    );
                    if(in_array($search, $this->{$key."Keywords"})){
                        $this->mapping[$key] = $heading;
                        break;
                    }
                }

            }
        }
    }

    /**
     * Returns the column name with the most IBANs present (if any)
     *
     * @param array $data
     * @return string|null
     */
    private function guessIbanField($data){
        $iban_counts = [];

        // Walk the array and count valid IBANs per column
        foreach($data as $row){
            foreach($row as $key=>$value){
                if(!isset($iban_counts[$key])){
                    $iban_counts[$key] = 0;
                }

                $iban = new IBAN($value);
                if($iban->validate()){
                    $iban_counts[$key]++;
                }
            }
        }

        // Sort the keys descending
        arsort($iban_counts);
        $keys = array_keys($iban_counts);

        // Check if first (highest) item exists
        if( ! isset($keys[0])){
            return null;
        }

        // Return the highest item, if more than zero ibans have been found
        $iban_key = $keys[0];

        return $iban_counts[$iban_key] > 0 ? $iban_key : null;
    }

    /**
     * Get the complete guessed column mapping
     * KEYS: type (iban, amount, etc.)
     * VALUES: column title
     *
     * @return string[]
     */
    public function getMapping()
    {
        return $this->mapping;
    }

    /**
     * Get the column index of the specified mapping
     *
     * @param $field
     * @return int|null
     */
    private function getIndex($field){
        if(isset($this->mapping[$field])){
            return array_search($this->mapping[$field], $this->headings);
        }
        return null;
    }

    /**
     * Get the index of the amount column
     *
     * @return int|null
     */
    public function getAmountIndex()
    {
        return $this->getIndex('amount');
    }

    /**
     * Get the index of the description column
     *
     * @return int|null
     */
    public function getDescriptionIndex()
    {
        return $this->getIndex('description');
    }

    /**
     * Get the index of the payer column
     *
     * @return int|null
     */
    public function getPayerIndex()
    {
        return $this->getIndex('payer');
    }

    /**
     * Get the index of the iban column
     *
     * @return int|null
     */
    public function getIbanIndex()
    {
        return $this->getIndex('iban');
    }

    /**
     * Get the index of the date column
     *
     * @return int|null
     */
    public function getDateIndex()
    {
        return $this->getIndex('date');
    }
}