<?php

namespace Frc\WP\View\Component;

abstract class Component
{
    /**
     * HTML tag
     *
     * @var string
     */
    public $as = 'div';

     /**
     * Inner HTML
     *
     * @var mixed
     */
    public $children = '';

    public $attributes;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if ($key === 'attributes') {
                $this->attributes = new ComponentAttributeBag($value);
                continue;
            }

            $this->$key = $value;
        }

        $this->attributes = $this->attributes ?? new ComponentAttributeBag;

        $this->init();
    }

    public function __get($key)
    {
        return $this->$key ?? null;
    }

    public function init() {}
}
