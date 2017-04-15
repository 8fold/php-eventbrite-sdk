<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\ApiResource;

use Eightfold\Eventbrite\Classes\Eventbrite;

class Venue extends ApiResource
{
    /**
     * REQUIRED: Defines the base endpoint for the resource.
     */
    const endpointEntry = 'venues/';
    const classPath = __CLASS__;

    public function name()
    {
        return $this->raw['name'];
    }

    public function localizedAddress()
    {
        return $this->raw['address']['localized_address_display'];
    }
}