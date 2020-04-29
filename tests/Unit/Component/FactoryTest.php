<?php

namespace Tests\Unit\Component;

use Tests\TestCase;
use Frc\WP\View\Component\Factory;

class TestComponent
{
    public function render()
    {
        return 'Hello World';
    }
}

class DataTestComponent
{
    public function __construct($props)
    {
        foreach ($props as $key => $value) {
            $this->$key = $value;
        }
    }

    public function render()
    {
        return 'Hello ' . $this->name;
    }
}

class ViewComponent
{
    public function __construct($props)
    {
        foreach ($props as $key => $value) {
            $this->$key = $value;
        }
    }
}

class FactoryTest extends TestCase
{
    /** @test */
    public function it_should_return_render_as_string()
    {
        $this->assertStringContainsString(
            'Hello World',
            (new Factory)->make(TestComponent::class)
        );
    }

    /** @test */
    public function it_should_guess_the_class_render_as_string()
    {
        $this->assertStringContainsString(
            'Hello World',
            (new Factory(__NAMESPACE__))->make('test-component')
        );
    }


    /** @test */
    public function it_should_return_render_with_data()
    {
        $this->assertStringContainsString(
            'Hello Test',
            (new Factory)->make(DataTestComponent::class, ['name' => 'Test'])
        );

        $this->assertStringContainsString(
            'Hello Test',
            (new Factory(__NAMESPACE__))->make('data-test-component', ['name' => 'Test'])
        );
    }

    /** @test */
    public function it_should_return_view_as_array()
    {
        $this->assertEquals(
            ['view' => 'view-component', 'data' => ['title' => 'Test']],
            (new Factory)->make(ViewComponent::class, ['title' => 'Test'])
        );
    }
}
