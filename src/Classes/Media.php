<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\Abstracts\ApiResource;

use Eightfold\Eventbrite\Interfaces\ApiResourceInterface;
use Eightfold\Eventbrite\Interfaces\ApiResourceIsBase;
use Eightfold\Eventbrite\Interfaces\ApiResourcePostable;

/**
 * @todo Media uploads are interesting, need more clarity on what each type 
 *       does exactly.
 */
class Media extends ApiResource implements ApiResourceInterface, ApiResourceIsBase, ApiResourcePostable
{
    /**************/
    /* Interfaces */
    /**************/

    static public function baseEndpoint()
    {
        return 'media';
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
        return 'event';
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