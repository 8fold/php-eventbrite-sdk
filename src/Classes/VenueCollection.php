<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\Core\ApiCollection;

use Eightfold\Eventbrite\Classes\Venue;

/**
 * @package Collections
 */
class VenueCollection extends ApiCollection
{
    public function __construct($client, $endpoint)
    {
        parent::__construct($client, $endpoint, 'venues', Venue::class);
    }
}
