<?php

namespace App\Utils;

use Exception;

class Calculate
{
    private $quantity;

    /**
     * Create new instance of Calculate
     *
     * @return int $quantity
     * @return void
     */
    public function __construct(int $quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * Increment the given data.
     *
     * If the value is a negative quantity, then decrements and verify if the result is less than 0.
     *
     * @param int $value
     * @return int
     */
    public function increment($value)
    {
        $result = $this->quantity + $value;

        if ($result < 0) {
            throw new Exception('The operation cannot result in less than 0.', 500);
        }

        return $result;
    }
}
