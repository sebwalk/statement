<?php
namespace SebastianWalker\Statement\Matchers;

use SebastianWalker\Statement\Transaction;

class ListMatcher implements Matcher
{
    /**
     * The list of entities to look after
     *
     * @var array
     */
    private $entities;

    /**
     * The property to to match objects
     *
     * @var string
     */
    private $property;

    /**
     * PrefixMatcher constructor.
     *
     * @param mixed[] $entities
     * @param string|null $property
     */
    public function __construct($entities, $property = null)
    {
        $this->entities = $entities;
        $this->property = $property;
    }

    /**
     * Get all entities that the description matches
     *
     * @param Transaction $transaction
     * @return mixed[]
     */
    public function getEntities(Transaction $transaction)
    {
        $entities = array_filter($this->entities, function($entity) use($transaction) {
            return $this->transactionContainsEntity($transaction, $entity);
        });

        return array_values($entities);
    }

    /**
     * Returns whether the given transaction contains the entity in string form
     *
     * @param Transaction $transaction
     * @param mixed $entity
     * @return bool
     */
    private function transactionContainsEntity(Transaction $transaction, $entity)
    {
        if(is_array($entity)){
            $string = $entity[$this->property];
        }else if (is_object($entity)){
            $string = $entity->{$this->property};
        }else{
            $string = $entity;
        }

        if(empty($string)){
            return false;
        }

        return strpos($transaction->getDescription(), $string) !== false;
    }
}