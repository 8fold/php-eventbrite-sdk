<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\Core\ApiCollection;

use Eightfold\Eventbrite\Classes\Event;

/**
 * @package Collections
 */
class EventCollection extends ApiCollection
{
    private $client;

    private $pagination;

    private $raw;



    /**
     * [__construct description]
     * 
     * @param [type] $client  [description]
     * @param [type] $payload [description]
     */
    public function __construct($client, $payload)
    {
        $this->client = $client;

        $this->raw = $payload;

        if (isset($payload['pagination'])) {
            $this->pagination = $payload['pagination'];
            unset($payload['pagination']);

        }

        $array = [];
        foreach ($payload['events'] as $event) {
            $array[] = new Event($this->client, $event);

        }
        parent::__construct($array);
        // $class = Event::class;
        // $keyToInstantiate = 'events';
        // $keysToConvertToLocalVars = ['pagination'];
        // parent::__construct($payload, $client, $class, $keyToInstantiate, $keysToConvertToLocalVars);
    }
}
