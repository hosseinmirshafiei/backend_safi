<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_true_is_true()
    {
        //in feature test we access to all service laravel test but in unit test we have not access
        // $this->assertTrue(true);

        $number = "۱";
        $number2 = "1";
        $convert = convertPersianToEnglish($number);
        assertEquals($number2 , $convert);

    }
}
