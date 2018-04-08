<?php

namespace SebastianWalker\Statement\Normalizers;

use Carbon\Carbon;
use CMPayments\IBAN;

class DefaultNormalizer implements Normalizer
{
    /**
     * Normalize a string amount into a float number
     *
     * - remove thousands separators
     * - normalize float point (allow comma)
     * - remove any currency symbols
     *
     * @param string $string
     * @return float|null
     */
    public function amount($string)
    {
        $s = str_replace(".", "", $string);
        $s = str_replace(",", ".", $s);
        $s = filter_var($s, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $s = trim($s);

        if(is_numeric($s)){
            return floatval($s);
        }

        return null;
    }

    /**
     * Normalize a transaction description
     *
     * @param string $string
     * @return string|null
     */
    public function description($string)
    {
        return $this->normalizeString($string);
    }

    /**
     * Normalize a transaction payer
     *
     * @param string $string
     * @return string|null
     */
    public function payer($string)
    {
        return $this->normalizeString($string);
    }

    /**
     * Normalize and verify an IBAN
     * Returns null if an invalid IBAN is passed
     *
     * @param string $string
     * @return string|null
     */
    public function iban($string)
    {
        $iban = new IBAN($string);
        if(!$iban->validate()){
            return null;
        }
        return $iban->format();
    }

    /**
     * Parse string date of unknown format into a Carbon instance
     *
     * @param string $string
     * @return Carbon
     */
    public function date($string)
    {
        if(empty($string)){
            // Empty string
            return null;
        }

        try{
            // European format DD.MM.YY
            return Carbon::createFromFormat('d.m.y', $string)->startOfDay();

        }catch(\InvalidArgumentException $e){
            try{
                // European format DD.MM.YYYY or American format YYYY-MM-DD
                return Carbon::parse($string)->startOfDay();

            }catch(\Exception $e){
                // Not a date at all
                return null;
            }
        }
    }

    /**
     * Normalizes a free length string (removes unnecessary whitespace etc.)
     *
     * @param $string
     * @return string|null
     */
    private function normalizeString($string)
    {
        if(empty($string)){
            return null;
        }

        return trim(
            preg_replace('/\s+/', ' ', strval($string))
        );
    }
}