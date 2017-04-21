<?php

namespace Eightfold\Eventbrite\Classes\Abstracts;

use Eightfold\Eventbrite\Classes\Event;

use Eightfold\Eventbrite\Traits\Gettable;

class EventSub extends ApiResource
{
    use Gettable;

    protected $myEvent;

    static public function all(Event $event)
    {
        $eventbrite = $event->eventbrite;
        $baseEndpoint = $event->endpoint() .'/'. static::routeName();
        $ticketClasses = parent::getMany($event->eventbrite, $baseEndpoint);
        return $ticketClasses;
    }

    static public function find($event, string $id)
    {
        $endpoint = $event->endpoint .'/'. static::routeName() .'/'. $id;
        return $event->eventbrite->get($endpoint, [], __CLASS__);
    }

    public function event()
    {
        if (is_null($this->myEvent)) {
            $this->myEvent = Event::find($this->eventbrite, $this->event_id);
        }
        return $this->myEvent;
    }
}