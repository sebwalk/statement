<?php
namespace SebastianWalker\Statement\Matchers;

use SebastianWalker\Statement\Transaction;

class PrefixMatcher implements Matcher
{
    /**
     * The prefix to look for in transaction descriptions.
     *
     * @var string
     */
    private $prefix;

    /**
     * PrefixMatcher constructor.
     * @param string $prefix
     */
    public function __construct($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * Get all entities that this transaction matches.
     *
     * @param Transaction $transaction
     * @return mixed[]
     */
    public function getEntities(Transaction $transaction)
    {
        $matches = $this->getRegexMatches($transaction);
        $entities = array_map([$this, 'stringToEntity'], $matches);

        return array_filter($entities);
    }

    /**
     * Get all prefix regex matches that the description contains.
     *
     * @param Transaction $transaction
     * @return string[]
     */
    public function getRegexMatches(Transaction $transaction)
    {
        preg_match_all($this->getRegex(), $transaction->getDescription(), $matches);

        if(isset($matches[1])){
            return $matches[1];
        }

        return [];
    }

    /**
     * Convert the matched string to a matchable object
     * You may also look up and include a domain object (such as DB record) in this place
     *
     * @param string $match_string
     * @return mixed
     */
    public function stringToEntity($match_string)
    {
        return $match_string;
    }

    /**
     * Get the regex string for prefix matching.
     *
     * @return string
     */
    private function getRegex()
    {
        return '/(?:^|\s)'.$this->prefix.'{1}([^\s]+)/';
    }
}