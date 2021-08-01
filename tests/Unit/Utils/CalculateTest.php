<?php

namespace Tests\Unit\Utils;

use App\Utils\Calculate;
use PHPUnit\Framework\TestCase;

class CalculateTest extends TestCase
{
    /**
     * Testing the sum of two numbers.
     *
     * @return void
     */
    public function test_to_sum_two_values()
    {
        $calculate = new Calculate(10);
        $this->assertEquals(15, $calculate->increment(5));
    }

    /**
     * Testing the subtract of two numbers.
     *
     * @return void
     */
    public function test_to_subtract_two_values()
    {
        $calculate = new Calculate(10);
        $this->assertEquals(5, $calculate->increment(-5));
    }
}
