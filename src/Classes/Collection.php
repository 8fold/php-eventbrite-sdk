<?php

namespace Eightfold\Eventbrite\Classes;

use Iterator;

use Eightfold\Eventbrite\Traits\ClassMappable;

class Collection implements Iterator
{
    use ClassMappable;

    private $position = 0;
    private $array = [];  
    private $eventbrite = null;

    public $total = 0;
    public $page = 0;
    public $size = 0;
    public $count = 0;

    public function __construct($payload, $eventbrite) {
        $this->position = 0;
        $this->total = $payload['pagination']['object_count'];
        $this->page  = $payload['pagination']['page_number'];
        $this->size  = $payload['pagination']['page_size'];
        $this->count = $payload['pagination']['page_count'];
        foreach ($payload as $key => $value) {
            if ($key !== 'pagination' && array_key_exists($key, $this->classMap)) {
                $class = $this->classMap[$key];
                foreach ($value as $resourcePayload) {
                    $this->array[] = new $class($resourcePayload, $eventbrite);
                }
            }
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