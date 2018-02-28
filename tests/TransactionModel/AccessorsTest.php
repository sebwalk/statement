<?php

class AccessorsTest extends \PHPUnit\Framework\TestCase
{
    public function testAmountAccessor()
    {
        $transaction = $this->getSampleTransaction();
        $this->assertSame(12.34, $transaction->getAmount());
    }

    public function testDescriptionAccessor()
    {
        $transaction = $this->getSampleTransaction();
        $this->assertSame("Transaction Description", $transaction->getDescription());
    }

    public function testPayerAccessor()
    {
        $transaction = $this->getSampleTransaction();
        $this->assertSame("Sebastian Walker", $transaction->getPayer());
    }

    public function testIbanAccessor()
    {
        $transaction = $this->getSampleTransaction();
        $this->assertSame("DE89370400440532013000", $transaction->getIban());
    }

    public function testDateAccessor()
    {
        $transaction = $this->getSampleTransaction();
        $this->assertEquals((new \Carbon\Carbon("2018-02-12"))->startOfDay(), $transaction->getDate());
    }

    private function getSampleTransaction()
    {
        return new \SebastianWalker\Statement\Transaction(
            12.34,
            "Transaction Description",
            "Sebastian Walker",
            "DE89370400440532013000",
            (new \Carbon\Carbon("2018-02-12"))->startOfDay()
        );
    }
}