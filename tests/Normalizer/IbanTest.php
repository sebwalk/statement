<?php

class IbanTest extends \PHPUnit\Framework\TestCase
{
    public function testValidIban()
    {
        $output = $this->normalizer()->iban("DE89370400440532013000");
        $this->assertEquals("DE89370400440532013000", $output);
    }

    public function testInvalidIban()
    {
        $output = $this->normalizer()->iban("DE89370400440532013001");
        $this->assertNull($output);
    }

    public function testEmptyString()
    {
        $output = $this->normalizer()->iban("");
        $this->assertNull($output);
    }

    public function testNull()
    {
        $output = $this->normalizer()->iban(null);
        $this->assertNull($output);
    }

    private function normalizer()
    {
        return new \SebastianWalker\Statement\Normalizers\DefaultNormalizer();
    }
}