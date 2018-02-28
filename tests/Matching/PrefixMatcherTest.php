<?php

class PrefixMatcherTest extends \PHPUnit\Framework\TestCase
{
    public function testMatchesStrings()
    {
        $matcher = new \SebastianWalker\Statement\Matchers\PrefixMatcher("PFIX-");
        $transaction = new \SebastianWalker\Statement\Transaction(10, "PAYMENT FOR PFIX-1234");

        $matches = $matcher->getEntities($transaction);

        $this->assertSame(["1234"], $matches);
    }

    public function testMatchesMultipleStrings()
    {
        $matcher = new \SebastianWalker\Statement\Matchers\PrefixMatcher("PFIX-");
        $transaction = new \SebastianWalker\Statement\Transaction(10, "PAYMENT FOR PFIX-1234 AND PFIX-5678");

        $matches = $matcher->getEntities($transaction);

        $this->assertSame(["1234","5678"], $matches);
    }

    public function testMatchesNothing()
    {
        $matcher = new \SebastianWalker\Statement\Matchers\PrefixMatcher("PFIX-");
        $transaction = new \SebastianWalker\Statement\Transaction(10, "PAYMENT FOR SOMETHING ELSE");

        $matches = $matcher->getEntities($transaction);

        $this->assertSame([], $matches);
    }
}