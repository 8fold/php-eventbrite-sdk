<?php

namespace Eightfold\Eventbrite\Classes\SubObjects;

use Eightfold\Eventbrite\Classes\SubObjects\EventSub;

/**
 * @package EventSub alias
 */
class Team extends EventSub
{
    /**
     * GET /events/:id/teams/:id/attendees/ - Returns attendee for a single
     *                                        attendee-team.
     *
     * ex. $eventbrite->event({id})->team({id})->attendees
     *
     * @return [type] [description]
     *
     * @todo Test and implement
     */
    public function attendees()
    {

    }
}
