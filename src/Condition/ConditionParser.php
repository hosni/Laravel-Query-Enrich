<?php

namespace sbamtr\LaravelQueryEnrich\Condition;

use sbamtr\LaravelQueryEnrich\Advanced\IsNull;
use sbamtr\LaravelQueryEnrich\Exception\InvalidArgumentException;
use sbamtr\LaravelQueryEnrich\Raw;

/**
 * Responsible for parsing conditions for use in queries.
 * This class takes an array of conditions and returns an instance of Condition, ConditionChain, or Raw depending on the input.
 */
class ConditionParser
{
    /**
     * Parses an array of conditions.
     *
     * @param array $conditions An array of conditions.
     *
     * @throws InvalidArgumentException If the input is invalid.
     *
     * @return Condition|ConditionChain|Raw Depending on the input, this method returns an instance of Condition, ConditionChain, or Raw.
     */
    public static function parse(array $conditions): Condition|ConditionChain|IsNull|Raw
    {
        if (count($conditions) === 1) {
            $condition = reset($conditions);

            if ($condition instanceof Raw) {
                return $condition;
            }
            if ($condition instanceof IsNull) {
                return $condition;
            }
        }
        if ($conditions[0] instanceof Condition) {
            return new ConditionChain($conditions);
        }
        if (count($conditions) === 2 || count($conditions) === 3) {
            return new Condition(...$conditions);
        }

        throw new InvalidArgumentException('Invalid condition');
    }
}
