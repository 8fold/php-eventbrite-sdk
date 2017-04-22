<?php

namespace Eightfold\Eventbrite\Classes\Abstracts;

use Eightfold\Eventbrite\Classes\Event;

use Eightfold\Eventbrite\Traits\Gettable;

class EventSub extends ApiResource
{
    public function event()
    {
        $endpoint = 'events/'. $this->event_id;
        return $this->hasOne(Event::class, $endpoint);
    }
}