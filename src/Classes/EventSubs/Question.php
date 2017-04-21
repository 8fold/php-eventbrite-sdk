<?php

namespace Eightfold\Eventbrite\Classes\EventSubs;

use Eightfold\Eventbrite\Classes\ApiResource;

class Question extends ApiResource
{
    static public function routeName()
    {
        return 'ticket_classes';
    }

    /**************/
    /* Interfaces */
    /**************/

    static public function classPath()
    {
        return __CLASS__;
    }

    public function endpoint()
    {
        return $this->event()->endpoint .'/ticket_classes/'. $this->id;
    }

    static public function parameterPrefix()
    {
        return 'ticket_class';
    }

    static public function parametersToPost()
    {
        return [
        ];
    }

    static public function parametersToConvertToDotNotation()
    {
        return [];
    }
}