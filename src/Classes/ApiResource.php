<?php

namespace Eightfold\Eventbrite\Classes;

class ApiResource
{
    /**
     * Used for querying the Eventbrite api related to events.
     * @var null
     */
    protected $eventbrite = null;

    public function __construct($payload, $eventbrite = null)
    {
        $setup = (isset($payload['body']))
            ? $payload['body']
            : $payload;
        foreach ($setup as $key => $value) {
            $this->{$key} = $value;
        }
        $this->eventbrite = $eventbrite;
    }
}