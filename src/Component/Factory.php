<?php

namespace Frc\WP\View\Component;

use ReflectionClass;
use Frc\WP\View\View;

class Factory
{
    protected $namespace;

    public function __construct($namespace = '')
    {
        $this->namespace = $namespace;
    }

    protected function guessClassName($component)
    {
        $className = str_replace('-', '', ucwords($component, '-/'));

        $className = str_replace('/', '\\', $className);

        return $this->getNamespace() . $className;
    }

    protected function getNamespace()
    {
       return rtrim($this->namespace, '\\') . '\\';
    }

    protected function componentClass($component)
    {
        if (class_exists($component)) {
            return $component;
        }

        if (class_exists($class = $this->guessClassName($component))) {
            return $class;
        }
    }

    public function make($component, $data = [])
    {
        if (! is_array($data)) {
            $data = ['children' => $data];
        }

        $className = $this->componentClass($component);

        if ($className) {
            $instance = new $className($data);

            $ref = new ReflectionClass($instance);

            $name = $ref->getShortName();
            $name = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $name));

            $dir = dirname($component);
            if ($dir === '.') {
                $dir = '';
            } else {
                $dir = $dir . DIRECTORY_SEPARATOR;
            }
            $name = $dir . $name;

            $data = get_object_vars($instance);

            if (method_exists($instance, 'render')) {
                $renderer = $instance->render();

                if ($renderer instanceof View) {
                    return $renderer->with($data);
                }

                return $renderer;
            }
        }

        return [
            'view' => $name ?? $component,
            'data' => $data,
        ];
    }
}
