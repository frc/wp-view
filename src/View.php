<?php

namespace Frc\WP\View;

use Throwable;

class View
{
    protected $view;

    protected $path;

    protected $data = [];

    public function __construct($view, $path, $data = [])
    {
        $this->view = $view;

        $this->path = $path;

        $this->with($data);
    }

    public function render()
    {
        $obLevel = ob_get_level();

        ob_start();

        $__data = $this->data;
        extract($this->data, EXTR_SKIP);

        try {
            include $this->path;
        } catch (Throwable $e) {
            while (ob_get_level() > $obLevel) {
                ob_end_clean();
            }

            throw $e;
        }

        return ltrim(ob_get_clean());
    }

    public function with($key, $value = null)
    {
        if (! is_array($key) && $value === null) {
            $this->data = [
                'children' => $key,
            ];
        } elseif (is_array($key) && ! (array_keys($key) !== range(0, count($key) - 1))) {
            $this->data = [
                'children' => "\n" . join("\n", $key) . "\n",
            ];
        } elseif (is_array($key) && array_key_exists('children', $key) && is_array($key['children']) ) {
            $this->data = array_merge($key, [
                'children' => "\n" . join("\n", $key['children']) . "\n",
            ]);
        } elseif (is_array($key)) {
            $this->data = array_merge($this->data, $key);
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }

    public function name()
    {
        return $this->view;
    }

    public function __toString()
    {
        return $this->render();
    }
}
