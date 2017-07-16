<?php

namespace Eightfold\Eventbrite\Classes\SubObjects;

use Eightfold\Eventbrite\Classes\Core\ApiCollection;

use Eightfold\Eventbrite\Classes\SubObjects\Attendee;

/**
 * @package Collections
 */
class AttendeeCollection extends ApiCollection
{
    public function __construct($client, $endpoint, $options = [])
    {
        parent::__construct($client, $endpoint, 'attendees', Attendee::class, $options);
    }
}
