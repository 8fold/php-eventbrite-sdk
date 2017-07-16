<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\Core\ApiCollection;

use Eightfold\Eventbrite\Classes\Event;

/**
 * @package Collections
 */
class EventCollection extends ApiCollection
{

    /**
     * [__construct description]
     *
     * @param [type] $client  [description]
     * @param [type] $payload [description]
     */
    public function __construct($client, $endpoint)
    {
        parent::__construct($client, $endpoint, 'events', Event::class);
    }
}
