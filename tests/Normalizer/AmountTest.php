<?php

class AmountTest extends \PHPUnit\Framework\TestCase
{
    public function testSimpleNumber()
    {
        $output = $this->normalizer()->amount("1234");
        $this->assertEquals(1234, $output);
    }

    public function testThousandsSeparatedNumber()
    {
        $output = $this->normalizer()->amount("1.234");
        $this->assertEquals(1234, $output);
    }

    public function testDecimalCommaNumber()
    {
        $output = $this->normalizer()->amount("1234,56");
        $this->assertEquals(1234.56, $output);
    }

    public function testThousandsSeparatedDecimalCommaNumber()
    {
        $output = $this->normalizer()->amount("1.234,56");
        $this->assertEquals(1234.56, $output);
    }

    public function testNegativeNumber()
    {
        $output = $this->normalizer()->amount("-1234");
        $this->assertEquals(-1234, $output);
    }

    public function testNegativeThousandsSeparatedNumber()
    {
        $output = $this->normalizer()->amount("-1.234");
        $this->assertEquals(-1234, $output);
    }

    public function testNegativeDecimalCommaNumber()
    {
        $output = $this->normalizer()->amount("-1234,56");
        $this->assertEquals(-1234.56, $output);
    }

    private function normalizer()
    {
        return new \SebastianWalker\Statement\Normalizers\DefaultNormalizer();
    }
}