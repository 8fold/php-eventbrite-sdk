<?php

namespace Eightfold\Eventbrite\Classes\SubObjects;

use Eightfold\Eventbrite\Classes\Core\ApiResource;

use Eightfold\Eventbrite\Classes\Event;

use Eightfold\Eventbrite\Interfaces\ExpandableInterface;

class EventSub extends ApiResource implements ExpandableInterface
{
    static public function expandedByDefault()
    {
        return ['event'];
    }

    public function event()
    {
        $endpoint = 'events/'. $this->event_id;
        return $this->hasOne(Event::class, $endpoint);
    }
}