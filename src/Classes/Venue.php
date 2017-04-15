<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\ApiResource;

use Eightfold\Eventbrite\Classes\Eventbrite;

class Venue extends ApiResource
{
    public function getName()
    {
        return $this->name;
    }

    public function getLocalizedAddress()
    {
        return $this->address['localized_address_display'];
    }
}