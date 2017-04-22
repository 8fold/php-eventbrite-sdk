<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\Abstracts\ApiResource;

// use Eightfold\Eventbrite\Classes\Event;

use Eightfold\Eventbrite\Interfaces\ApiResourceInterface;
// use Eightfold\Eventbrite\Interfaces\ApiResourceIsBase;
// use Eightfold\Eventbrite\Interfaces\ApiResourcePostable;

class Order extends ApiResource implements ApiResourceInterface
{
    /**************/
    /* Interfaces */
    /**************/

    static public function expandedByDefault()
    {
        return ['event', 'attendees', 'refund_requests'];
    }

    static public function baseEndpoint()
    {
        return 'orders';
    }

    static public function classPath()
    {
        return __CLASS__;
    }

    public function endpoint()
    {
        return self::baseEndpoint() .'/'. $this->id;
    }    
}