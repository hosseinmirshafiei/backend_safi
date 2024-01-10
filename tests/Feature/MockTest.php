<?php

namespace Tests\Feature;

use App\Http\Controllers\TController;
use App\Http\Services\Serrr;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class MockTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        Mockery::mock(Serrr::class, function (MockInterface $mock) {
            $mock->shouldReceive('m')->once()->andReturn("test");
        });
        app(TController::class)->index();
    }
}
