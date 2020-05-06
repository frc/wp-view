<?php

namespace Tests\Unit\Component;

use Tests\TestCase;
use Frc\WP\View\Component\AnonymousComponent;

class ComponentTest extends TestCase
{
    /** @test */
    public function it_should_expose_default_props()
    {
        $component = new AnonymousComponent;
        $data = get_object_vars($component);

        $this->assertArrayHasKey('as', $data);
        $this->assertArrayHasKey('attributes', $data);
        $this->assertArrayHasKey('children', $data);
    }

    /** @test */
    public function it_should_expose_custom_props()
    {
        $component = new AnonymousComponent([
            'title' => 'Hello World!',
            'context' => 'test',
        ]);
        $data = get_object_vars($component);

        $this->assertArrayHasKey('title', $data);
        $this->assertArrayHasKey('context', $data);
    }
}
