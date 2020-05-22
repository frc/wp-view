<?php

namespace Tests\Unit;

use Tests\TestCase;
use Frc\WP\View\View;
use Frc\WP\View\Factory;
use Frc\WP\View\FileFinder;

class FactoryTest extends TestCase
{
    protected function factory()
    {
        return new Factory(
            new FileFinder([
                __DIR__ . '/../stubs/views'
            ])
        );
    }
    /** @test */
    public function it_should_return_instance_of_view()
    {
        $this->assertInstanceOf(
            View::class,
            $this->factory()->make('index')
        );
    }

    /** @test */
    public function it_should_merge_data_arrays()
    {
        $view = $this->factory()->make(
            'merge-data',
            ['title' => 'Custom Title'],
            ['title' => 'default', 'link' => '#test']
        )->render();

        $this->assertStringContainsString('Custom Title', $view);
    }

     /** @test */
    public function it_should_find_first_view()
    {
        $view = $this->factory()->first(
            [
                'not-exists',
                'index',
                'merge-data',
            ],
        );

        $this->assertEquals('index', $view->name());
    }
}
