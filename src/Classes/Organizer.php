<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\ApiResource;

class Organizer extends ApiResource
{
    /**
     * REQUIRED: Defines the base endpoint for the resource.
     */
    const endpointEntry = 'organizers/';
    const classPath = __CLASS__;
}