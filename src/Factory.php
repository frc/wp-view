<?php

namespace Frc\WP\View;

use InvalidArgumentException;

class Factory
{
    protected $finder;

    public function __construct(FileFinder $finder)
    {
        $this->finder = $finder;
    }

    public function file($path, $data = [])
    {
        return $this->viewInstance($path, $path, $data);
    }

    public function make($view, $data = [])
    {
        $path = $this->finder->find($view);

        return $this->viewInstance($view, $path, $data);
    }

    protected function viewInstance($view, $path, $data)
    {
        return new View($view, $path, $data);
    }

    public function exists($view)
    {
        try {
            $this->finder->find($view);
        } catch (InvalidArgumentException $e) {
            return false;
        }

        return true;
    }
}
