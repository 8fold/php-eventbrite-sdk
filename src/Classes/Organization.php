<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\Individual;

class Organization extends Individual
{
        /**
     * REQUIRED: Defines the base endpoint for the resource.
     */
    const endpointEntry = 'users/';
    const classPath = __CLASS__;
}