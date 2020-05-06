<?php

namespace Frc\WP\View\Component;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;

/**
 * @copyright Taylor Otwell
 * @link https://github.com/laravel/framework/blob/7.x/src/Illuminate/View/ComponentAttributeBag.php
 */

class ComponentAttributeBag implements ArrayAccess, IteratorAggregate
{
    /**
     * The raw array of attributes.
     *
     * @var array
     */
    protected $attributes = [];

     /**
     * Create a new component attribute bag instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * Merge additional attributes / values into the attribute bag.
     *
     * @param  array  $attributes
     * @return static
     */
    public function merge(array $attributeDefaults = [])
    {
        $attributes = [];

        $attributeDefaults = array_map(function ($value) {
            if (is_null($value) || is_bool($value)) {
                return $value;
            }

            return ($value);
        }, $attributeDefaults);

        foreach ($this->attributes as $key => $value) {
            if ($key !== 'class') {
                $attributes[$key] = $value;

                continue;
            }

            $attributes[$key] = implode(' ', array_unique(
                array_filter([$attributeDefaults[$key] ?? '', $value])
            ));
        }

        return new static(array_merge($attributeDefaults, $attributes));
    }

    /**
     * Determine if the given offset exists.
     *
     * @param  string  $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->attributes[$offset]);
    }

    /**
     * Get the value at the given offset.
     *
     * @param  string  $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->attributes[$offset] ?? '';
    }

    /**
     * Set the value at a given offset.
     *
     * @param  string  $offset
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->attributes[$offset] = $value;
    }

    /**
     * Remove the value at the given offset.
     *
     * @param  string  $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->attributes[$offset]);
    }

    /**
     * Get an iterator for the items.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->attributes);
    }

    /**
     * Implode the attributes into a single HTML ready string.
     *
     * @return string
     */
    public function __toString()
    {
        $string = '';

        foreach ($this->attributes as $key => $value) {
            if ($value === false || is_null($value)) {
                continue;
            }

            if ($value === true) {
                $value = $key;
            }

            $key = esc_attr($key);

            $value = preg_replace('/\s+/', ' ', $value);

            if (in_array($key, ['href', 'src'])) {
                $value = esc_url($value);
            } else {
                $value = esc_attr($value);
            }

            $string .= ' '.$key.'="'.str_replace('"', '\\"', trim($value)).'"';
        }

        return trim($string);
    }
}
