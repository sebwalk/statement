<?php

class PrefixMatcherWithFixedLengthTest extends \PHPUnit\Framework\TestCase
{
    public function testMatchesStrings()
    {
        $matcher = new \SebastianWalker\Statement\Matchers\PrefixMatcher("PFIX-", 4);
        $transaction = new \SebastianWalker\Statement\Transaction(10, "PAYMENT FOR PFIX-1234SOME OTHER STUFF");

        $matches = $matcher->getEntities($transaction);

        $this->assertSame(["1234"], $matches);
    }

    public function testMatchesMultipleStrings()
    {
        $matcher = new \SebastianWalker\Statement\Matchers\PrefixMatcher("PFIX-", 4);
        $transaction = new \SebastianWalker\Statement\Transaction(10, "PAYMENT FOR PFIX-1234SOME OTHER STUFF AND PFIX-5678SOME MORE STUFF");

        $matches = $matcher->getEntities($transaction);

        $this->assertSame(["1234","5678"], $matches);
    }

    public function testMatchesNothing()
    {
        $matcher = new \SebastianWalker\Statement\Matchers\PrefixMatcher("PFIX-", 4);
        $transaction = new \SebastianWalker\Statement\Transaction(10, "PAYMENT FOR SOMETHING ELSE");

        $matches = $matcher->getEntities($transaction);

        $this->assertSame([], $matches);
    }
}