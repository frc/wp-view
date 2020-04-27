<?php

namespace Tests\Unit;

use Frc\WP\View\FileFinder;
use Tests\TestCase;

class FileFinderTest extends TestCase
{
    /** @test */
    public function it_should_find_a_file()
    {
        $finder = new FileFinder([
            __DIR__ . '/../stubs/views'
        ]);

        $file = $finder->find('index');

        $this->assertFileExists($file);
    }
}
