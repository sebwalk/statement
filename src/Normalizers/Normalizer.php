<?php

namespace SebastianWalker\Statement\Normalizers;


interface Normalizer
{
    public function amount($string);

    public function description($string);

    public function payer($string);

    public function iban($string);

    public function date($string);
}