<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\ApiResource;

class TicketClass extends ApiResource
{
    public function getCost()
    {
        return $this->cost['value'];
    }

    public function getCostDisplay()
    {
        return $this->cost['display'];
    }
}