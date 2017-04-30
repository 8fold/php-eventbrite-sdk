<?php

namespace Eightfold\Eventbrite\Traits;

/**
 * Used for capturing parameter changes that should be posted on save.
 *
 * NOTE: If your class inherits from ApiResource and you want to have predefined
 *       private variables, then the class with the private variable should inherit
 *       this trait itself, as the parent class will not have insight.
 */
trait Settable
{
    public function __set($name, $value)
    {
        // we are not setting raw value itself.
        $propExists = (property_exists($this, $name) && isset($this->$name));
        if ($propExists) {
            $this->{$name} = $value;

        } elseif (method_exists($this, 'set'. $name)) {
            $setterName = 'set'. $name;
            $this->$setterName($value);

        } elseif ($name !== 'raw') {
            $raw = null;
            foreach ($this as $p => $v) {
                if ($p == 'raw') {
                    $raw = $v;
                    break;
                }
            }
            $hasRaw = (!is_null($raw));
            $hasChangedProperty = (property_exists($this, 'changed'));
            $isPostable = method_exists($this, 'parametersToPost');
            $propertyIsPostable = ($isPostable)
                ? (in_array($name, $this->parametersToPost()))
                : false;
            // we are an ApiResource with a raw value with a property called changed
            // 
            // and if raw has name
            if ($hasRaw && $hasChangedProperty && $isPostable && $propertyIsPostable) {
                $this->changed[$name] = $value;

            } else {
                $this->{$name} = $value;

            }         
        }
        return $this;
    }
}