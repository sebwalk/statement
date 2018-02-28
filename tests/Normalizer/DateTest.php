<?php

class DateTest extends \PHPUnit\Framework\TestCase
{
    public function testParsesEuropeanDateCorrectly()
    {
        $output = $this->normalizer()->date("22.08.2018");
        $this->assertEquals(new \Carbon\Carbon("2018-08-22"), $output);
    }

    public function testParsesEuropeanShortDateCorrectly()
    {
        $output = $this->normalizer()->date("22.08.18");
        $this->assertEquals(new \Carbon\Carbon("2018-08-22"), $output);
    }

    public function testParsesAmericanDateCorrectly()
    {
        $output = $this->normalizer()->date("2018-08-22");
        $this->assertEquals(new \Carbon\Carbon("2018-08-22"), $output);
    }

    public function testNullsInvalidDate()
    {
        $output = $this->normalizer()->date("this is not a date");
        $this->assertNull($output);
    }

    public function testNullsEmptyString()
    {
        $output = $this->normalizer()->date("");
        $this->assertNull($output);
    }

    public function testNullsNull()
    {
        $output = $this->normalizer()->date(null);
        $this->assertNull($output);
    }

    private function normalizer()
    {
        return new \SebastianWalker\Statement\Normalizers\DefaultNormalizer();
    }
}