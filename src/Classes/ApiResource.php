<?php

namespace Eightfold\Eventbrite\Classes;

class ApiResource
{
    /**
     * Used for querying the Eventbrite api related to events.
     * @var null
     */
    protected $eventbrite = null;

    private $raw = null;

    public function __construct($payload, $eventbrite = null)
    {
        $this->eventbrite = $eventbrite;
        $setup = (isset($payload['body']))
            ? $payload['body']
            : $payload;
        $this->raw = $setup;
        // foreach ($setup as $key => $value) {
        //     $this->data[$key] = $value;
        // }
        
    }

    public function __get(string $name)
    {
        if (array_key_exists($name, $this->raw)) {
            return $this->raw[$name];
        }
        dd($this->raw);
    }
}