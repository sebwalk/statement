<?php

class ListMatcherTest extends \PHPUnit\Framework\TestCase
{
    public function testMatchesStrings()
    {
        $matcher = new \SebastianWalker\Statement\Matchers\ListMatcher(["1234","5678","9012"]);
        $transaction = new \SebastianWalker\Statement\Transaction(10, "PAYMENT FOR 1234");

        $matches = $matcher->getEntities($transaction);

        $this->assertSame(["1234"], $matches);
    }

    public function testMatchesMultipleStrings()
    {
        $matcher = new \SebastianWalker\Statement\Matchers\ListMatcher(["1234","5678","9012"]);
        $transaction = new \SebastianWalker\Statement\Transaction(10, "PAYMENT FOR 1234 AND 9012");

        $matches = $matcher->getEntities($transaction);

        $this->assertSame(["1234", "9012"], $matches);
    }

    public function testMatchesNothing()
    {
        $matcher = new \SebastianWalker\Statement\Matchers\ListMatcher(["1234","5678","9012"]);
        $transaction = new \SebastianWalker\Statement\Transaction(10, "PAYMENT FOR SOMETHING ELSE");

        $matches = $matcher->getEntities($transaction);

        $this->assertSame([], $matches);
    }

    public function testMatchesArray()
    {
        $matcher = new \SebastianWalker\Statement\Matchers\ListMatcher([
            ["id"=>"1234"],
            ["id"=>"5678"],
            ["id"=>"9012"]
        ], "id");
        $transaction = new \SebastianWalker\Statement\Transaction(10, "PAYMENT FOR 1234");

        $matches = $matcher->getEntities($transaction);

        $this->assertSame([["id"=>"1234"]], $matches);
    }

    public function testMatchesObject()
    {
        $matcher = new \SebastianWalker\Statement\Matchers\ListMatcher([
            (object)["id"=>"1234"],
            (object)["id"=>"5678"],
            (object)["id"=>"9012"]
        ], "id");
        $transaction = new \SebastianWalker\Statement\Transaction(10, "PAYMENT FOR 1234");

        $matches = $matcher->getEntities($transaction);

        $this->assertEquals([(object)["id"=>"1234"]], $matches);
    }
}