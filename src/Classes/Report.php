<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\Core\ApiResource;

use Eightfold\Eventbrite\Classes\SubObjects\Attendee;
use Eightfold\Eventbrite\Classes\SubObjects\Sale;

abstract class Report extends ApiResource
{
    // TODO: Actually implement - not sure if there is demand to though.
    public function sales()
    {
        $endpoint = 'reports/sales';
        return $this->hasMany(Sale::class, $endpoint);
    }

    // TODO: Actually implement - not sure if there is demand to though.
    public function attendees()
    {
        $endpoint = 'reports/attendees';
        return $this->hasMany(Attendee::class, $endpoint);
    }
}