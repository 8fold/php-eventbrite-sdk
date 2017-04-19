<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\ApiResource;

use Eightfold\Eventbrite\Classes\Event;

class Individual extends ApiResource
{
    /**
     * REQUIRED: Defines the base endpoint for the resource.
     */
    const endpointEntry = 'users/me';
    const classPath = __CLASS__;

    private $events = null;

    private $upcomingEvents = null;

    public function events()
    {
        if (is_null($this->events)) {
            $endpoint = static::endpointEntry .'/owned_events';
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
            $endpoint = static::endpointEntry .'/owned_events';
            $options = [
                'order_by' => 'start_desc', 
                'status' => 'live'
            ];

            $this->upcomingEvents = $this->eventbrite->get($endpoint, $options, Event::class);                    
        }
        return $this->upcomingEvents;
    }
}