<?php

namespace Eightfold\Eventbrite\Classes\EventSubs;

use Eightfold\Eventbrite\Classes\Abstracts\EventSub;
use Eightfold\Eventbrite\Interfaces\EventSubInterface;

use Eightfold\Eventbrite\Classes\Event;

class AccessCode extends EventSub implements EventSubInterface
{
    public function event()
    {
        $endpoint = 'events/'. $this->event_id;
        return $this->hasOne(Event::class, $endpoint);
    } 

    static public function expandedByDefault()
    {
        return ['event'];
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