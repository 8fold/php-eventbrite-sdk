<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\ApiResource;

use Eightfold\Eventbrite\Interfaces\ApiResourceInterface;
use Eightfold\Eventbrite\Interfaces\ApiResourceIsBase;
use Eightfold\Eventbrite\Interfaces\ApiResourcePostable;

class Organizer extends ApiResource implements ApiResourceInterface, ApiResourceIsBase, ApiResourcePostable
{
    /**************/
    /* Interfaces */
    /**************/

    static public function baseEndpoint()
    {
        return 'organizers';
    }

    static public function classPath()
    {
        return __CLASS__;
    }

    public function endpoint()
    {
        return static::baseEndpoint() .'/'. $this->id;
    }      

    static public function parameterPrefix()
    {
        return 'organizer';
    }

    static public function parametersToPost()
    {
        return [
        ];
    }

    static public function parametersToConvertToDotNotation()
    {
        return [
        ];        
    }    
}