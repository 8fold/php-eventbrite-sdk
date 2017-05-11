<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\Core\ApiCollection;

use Eightfold\Eventbrite\Classes\Event;

/**
 * @package Collections
 */
class EventCollection extends ApiCollection
{
    public function __construct(array $payload, $client)
    {
        $class = Event::class;
        $keyToInstantiate = 'events';
        $keysToConvertToLocalVars = ['pagination'];
        parent::__construct($payload, $client, $class, $keyToInstantiate, $keysToConvertToLocalVars);
    }
}
