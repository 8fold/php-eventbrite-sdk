<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\ApiResource;

use Eightfold\Eventbrite\Interfaces\ApiResourceInterface;
use Eightfold\Eventbrite\Interfaces\ApiResourceIsBase;

class Format extends ApiResource implements ApiResourceInterface, ApiResourceIsBase
{
    /**************/
    /* Interfaces */
    /**************/

    static public function baseEndpoint()
    {
        return 'formats';
    }

    static public function classPath()
    {
        return __CLASS__;
    }

    public function endpoint()
    {
        return static::baseEndpoint() .'/'. $this->id;
    }
}