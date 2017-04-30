<?php

namespace Eightfold\Eventbrite\Classes\SubObjects;

use Eightfold\Eventbrite\Classes\Core\ApiCollection;

use Eightfold\Eventbrite\Classes\SubObjects\Attendee;

class AttendeeCollection extends ApiCollection
{
    public function __construct(array $payload, $client) 
    {
        $class = Attendee::class;
        $keyToInstantiate = 'attendees';
        $keysToConvertToLocalVars = ['pagination'];
        parent::__construct($payload, $client, $class, $keyToInstantiate, $keysToConvertToLocalVars);
    }
}