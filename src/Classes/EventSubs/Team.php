<?php

namespace Eightfold\Eventbrite\Classes\EventSubs;

use Eightfold\Eventbrite\Classes\Abstracts\EventSub;
use Eightfold\Eventbrite\Interfaces\EventSubInterface;

use Eightfold\Eventbrite\Classes\Event;

class Team extends EventSub implements EventSubInterface
{
    static public function expandedByDefault()
    {
        return [];
    }
    static public function routeName()
    {
        return 'access_codes';
    }

    static public function classPath()
    {
        return __CLASS__;
    }

    public function endpoint()
    {
        return $this->event()->endpoint .'/access_codes/'. $this->id;
    }

    static public function parameterPrefix()
    {
        return 'access_code';
    }

    static public function parametersToPost()
    {
        return [];
    }

    static public function parametersToConvertToDotNotation()
    {
        return [];
    }
}