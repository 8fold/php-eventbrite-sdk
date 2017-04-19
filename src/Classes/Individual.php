<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\ApiResource;

use Eightfold\Eventbrite\Classes\Event;

use Eightfold\Eventbrite\Interfaces\ApiResourceInterface;
use Eightfold\Eventbrite\Interfaces\ApiResourceIsBase;
use Eightfold\Eventbrite\Interfaces\ApiResourcePostable;

class Individual extends ApiResource implements ApiResourceInterface
{
    
    private $events = null;

    private $upcomingEvents = null;

    public function events()
    {
        if (is_null($this->events)) {
            $endpoint = $this->ownedEventsEndpoint;
            $options = [
                'order_by' => 'start_desc'
            ];
            $this->events = $this->eventbrite->get($endpoint, $options, Event::class);
        }
        return $this->events;
    }

    public function upcomingEvents()
    {
        if (is_null($this->upcomingEvents)) {
            $endpoint = $this->ownedEventsEndpoint;
            $options = [
                'order_by' => 'start_desc', 
                'status' => 'live'
            ];

            $this->upcomingEvents = $this->eventbrite->get($endpoint, $options, Event::class);                    
        }
        return $this->upcomingEvents;
    }

    private function ownedEventsEndpoint()
    {
        return $this->endpoint .'/owned_events';
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
        return 'users/me';
    }    
}