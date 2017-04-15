<?php

namespace Eightfold\Eventbrite\Transformations;

/**
 * Uses PHP's __get() magic method to allow calculated properties.
 * 
 */
trait Gettable
{
    public function __get(string $name)
    {
        if (isset($this->raw) && array_key_exists($name, $this->raw)) {
            return $this->raw[$name];

        }

        if (isset($this->{$name}) && !is_null($this->{$name})) {
            return $this->{$name};

        }

        if (method_exists($this, $name)) {
            return $this->$name();

        }
        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . __CLASS__ .
            ' on line ' . __LINE__,
            E_USER_NOTICE);
        return null; 
    }
}