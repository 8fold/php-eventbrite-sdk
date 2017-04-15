<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\ApiResource;

class Individual extends ApiResource
{
    /**
     * REQUIRED: Defines the base endpoint for the resource.
     */
    const endpointEntry = 'users/';
    const classPath = __CLASS__;

    protected $userBase = null;

    private $upcomingEvents = null;

    private $events = null;

    public function __construct($token, $eventbrite = null)
    {
        parent::__construct($token, $eventbrite);
        $this->userBase = 'users/'. $this->id .'/';
    }

    public function upcomingEvents()
    {
        if (is_null($this->upcomingEvents)) {
            $endpoint = $this->userBase .'owned_events/';
            $options = [
                'order_by' => 'start_desc', 
                'status' => 'live'
            ];
            $events = $this->eventbrite->get($endpoint, $options);
            $eventsReturn = $events['body']['events'];
            foreach ($eventsReturn as $event) {
                $this->upcomingEvents[] = new Event($event, $this->eventbrite);
            }                     
        }
        return $this->upcomingEvents;
    }
}