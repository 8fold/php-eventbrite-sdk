<?php

namespace Eightfold\Eventbrite\Classes\Reports;

use Eightfold\Eventbrite\Classes\Report;

use Eightfold\Eventbrite\Eventbrite;

use Eightfold\Eventbrite\Interfaces\ApiResourceInterface;

class Attendees extends Report implements ApiResourceInterface
{
    /**
     * TODO: The Event brite documentations says no parameters are required;
     *       however, the API itself does. Good opportunity for testing error handling.
     *
     * Required params: event_ids or event_status
     * 
     * @param  Eventbrite $eventbrite Eventbrite instance to use in API request.
     * @return Attendees              Instantiate this.
     */
    static public function get(Eventbrite $eventbrite)
    {
        return $eventbrite->get(static::baseEndpoint());
    }

    /**************/
    /* Interfaces */
    /**************/

    static public function baseEndpoint()
    {
        return 'reports/attendees';
    }

    static public function classPath()
    {
        return __CLASS__;
    }

    public function endpoint()
    {
        return static::baseEndpoint();
    }
}