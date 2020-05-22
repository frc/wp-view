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

    public function make($view, $data = [], $mergeData = [])
    {
        $path = $this->finder->find($view);

        $data = array_merge($mergeData, $data);

        return $this->viewInstance($view, $path, $data);
    }

    public function first(array $views, $data = [], $mergeData = [])
    {
        $view = false;
        foreach ($views as $name) {
            if ($this->exists($name)) {
                $view = $name;
                break;
            }
        }

        if (! $view) {
            throw new InvalidArgumentException('None of the views in the given array exist.');
        }

        return $this->make($view, $data, $mergeData);
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
