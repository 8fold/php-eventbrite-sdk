<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Traits\Gettable;

class ApiResource
{
    use Gettable;

    /**
     * Used for querying the Eventbrite api related to events.
     * @var null
     */
    protected $eventbrite = null;

    /**
     * The raw payload provided at instantiation. 
     * @var null
     */
    private $raw = null;

    public function __construct($payload, $eventbrite = null)
    {
        $this->eventbrite = $eventbrite;
        $setup = (isset($payload['body']))
            ? $payload['body']
            : $payload;
        $this->raw = $setup;
    }
}