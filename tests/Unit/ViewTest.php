<?php

namespace Tests\Unit;

use Tests\TestCase;
use Frc\WP\View\View;

class ViewTest extends TestCase
{
    protected function view($view, $data = [])
    {
        return new View(
            $view, // Name
            __DIR__ . '/../stubs/views/' . $view, // Path
            $data // Data
        );
    }

    /** @test */
    public function it_should_render_given_path()
    {
        $this->assertStringContainsString(
            '<div>Hello World!</div>',
            $this->view('index.php')->render()
        );
    }

    /** @test */
    public function it_should_render_given_path_with_data()
    {
        $this->assertStringContainsString(
            '<div>Hello View</div>',
            $this->view('data.template.php', ['title' => 'Hello View'])->render()
        );
    }

    /** @test */
    public function it_should_render_default_parameter_as_children()
    {
        $this->assertStringContainsString(
            '<div>Hello Default Parameter</div>',
            $this->view('children.php', 'Hello Default Parameter')->render()
        );
    }

    /** @test */
    public function it_should_render_array_default_parameter_as_children()
    {
        $this->assertStringContainsString(
            '<p>' . PHP_EOL .
            'This is in p-tag' . PHP_EOL .
            '</p>' .PHP_EOL,
            $this->view('children.php', [
                '<p>',
                'This is in p-tag',
                '</p>'
            ])->render()
        );
    }

     /** @test */
     public function it_should_render_array_parameter_as_children()
     {
         $this->assertStringContainsString(
             '<p>' . PHP_EOL .
             'This is in p-tag' . PHP_EOL .
             '</p>' .PHP_EOL,
             $this->view('children.php', [
                 'children' => [
                    '<p>',
                    'This is in p-tag',
                    '</p>'
                 ]
             ])->render()
         );
     }
}
