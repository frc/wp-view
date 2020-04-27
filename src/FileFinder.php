<?php

namespace Frc\WP\View;

use InvalidArgumentException;

class FileFinder
{
    protected $paths = [];

    protected $views = [];

    protected $extensions = ['php'];

    public function __construct(array $paths = [])
    {
        $this->paths = array_unique(
            array_map([$this, 'resolvePath'], $paths)
        );
    }

    public function find($name)
    {
        if (isset($this->views[$name])) {
            return $this->views[$name];
        }

        return $this->views[$name] = $this->findInPaths($name, $this->paths);
    }

    protected function findInPaths($name, $paths)
    {
        foreach ((array) $paths as $path) {
            foreach ($this->getPossibleViewFiles($name) as $file) {
                if (file_exists($viewPath = "$path/$file")) {
                    return $viewPath;
                }
            }
        }

        throw new InvalidArgumentException("View [{$name}] not found.");
    }

    protected function getPossibleViewFiles($name)
    {
        return array_map(function ($extension) use ($name) {
            return "$name.$extension";
        }, $this->extensions);
    }

    protected function resolvePath($path)
    {
        return realpath($path) ?: $path;
    }
}
