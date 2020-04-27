<?php

namespace Tests\Unit;

use Tests\TestCase;
use Frc\WP\View\View;
use Frc\WP\View\Factory;
use Frc\WP\View\FileFinder;

class FactoryTest extends TestCase
{
    /** @test */
    public function it_should_return_instance_of_view()
    {
        $this->assertInstanceOf(
            View::class,
            (new Factory(new FileFinder([
                __DIR__ . '/../stubs/views'
            ])))->make('index')
        );
    }
}
