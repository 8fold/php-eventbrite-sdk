<?php

namespace Eightfold\Eventbrite\Classes\Core;

use ArrayObject;

use Eightfold\Eventbrite\Traits\ClassMappable;

class ApiCollection extends ArrayObject
{
    use ClassMappable;

    public function __construct(array $payload, $client, string $class, string $keyToInstantiate = null, array $keysToConvertToLocalVars = null
    ) {
        if (!is_null($keysToConvertToLocalVars) && is_array($keysToConvertToLocalVars)) {
            foreach($keysToConvertToLocalVars as $convertMe) {
                if (isset($payload[$convertMe])) {
                    $this->{$convertMe} = $payload[$convertMe];
                    unset($payload[$convertMe]);
                }
            }
        }

        if (!is_null($keyToInstantiate) && isset($payload[$keyToInstantiate])) {
            $array = [];
            foreach($payload[$keyToInstantiate] as $resourcePayload) {
                $array[] = new $class($resourcePayload, $client);
            }
            parent::__construct($array);

        } else {
            $single = new $class($payload, $client);
            parent::__construct([$single]);            
        }
    }

    public function rewind() {
        // var_dump(__METHOD__);
        $this->position = 0;
    }

    public function current() {
        // var_dump(__METHOD__);
        return $this->array[$this->position];
    }

    public function key() {
        // var_dump(__METHOD__);
        return $this->position;
    }

    public function next() {
        // var_dump(__METHOD__);
        ++$this->position;
    }

    public function valid() {
        // var_dump(__METHOD__);
        return isset($this->array[$this->position]);
    }
}