<?php

namespace Eightfold\Eventbrite;

use JamieHollern\Eventbrite\Eventbrite as EventbriteBase;

use Eightfold\Eventbrite\Traits\Gettable;

use Eightfold\Eventbrite\Classes\Organization;
use Eightfold\Eventbrite\Classes\Individual;
use Eightfold\Eventbrite\Classes\Organizer;
use Eightfold\Eventbrite\Classes\Events;

/**
 * Main Eventrbrite entry point.
 *
 * Create an instance of this class to connect to the Eventbrite API. Each instance
 * will be associated to an one account using the provided token.
 *
 * From a plain language perspective, there are two types of people who can have
 * accounts with Eventbrite: Organizations and Individuals. The Eventrbrite API
 * view both of these accounts types as the same thing. This library, however, doea
 * not. Therefore, you can tell the instance whether it should be treated as an
 * individual (human) or an organization (legal entity).
 * 
 */
class Eventbrite extends EventbriteBase
{
    use Gettable;

    private $organization = null;

    private $individual = null;

    /**
     * Creates an Eventbrite instance for a specific user.
     * 
     * @param string $token  Oauth token for application or individual
     * @param bool   $isOrg  Whether to treat the user associated as a human or not.
     * @param array  $config Configuration parameters for parent class.
     *
     * @return Eventbrite
     */
    static public function setAuthToken(string $token, $isOrg = false, $config = [])
    {
        return new Eventbrite($token, $isOrg, $config);
    }  

    /**
     * Intantiate Eventbrite instance.
     *
     * Caches Organization and the base endpoint for user-related queries.
     *
     * Organizations are the only user type that can establish an application;
     * therefore, the organization is all we care about with this instance.
     * 
     * @param string $token  Oauth token for application or individual
     * @param array  $config Configuration parameters for parent class.
     * @param bool   $isOrg  Whether the user to be associated with instance is an
     *                       an organization or a human
     */
    public function __construct(string $token, $isOrg = false, $config = [])
    {
        parent::__construct($token, $config);

        $orgOrUser = parent::get(parent::CURRENT_USER_ENDPOINT);
        if ($isOrg) {
            $this->organization = new Organization($orgOrUser, $this);    

        } else {
            $this->individual = new Individual($orgOrUser, $this);

        }
        // $this->orgBase = 'users/'. $this->organization->id .'/';
    }

    private function entity()
    {
        if (is_null($this->organization)) {
            return $this->individual;
        }
        return $this->organization;
    }

    public function upcomingEvents()
    {
        return $this->entity->upcomingEvents();
    }

    // public function getOrganizers()
    // {
    //     // TODO: This is a paginated retrun, account for that.
    //     if (count($this->organizers) == 0) {
    //         $organizers = parent::get($this->orgBase .'organizers/');
    //         $organizersReturn = $organizers['body']['organizers'];
    //         foreach ($organizersReturn as $organizer) {
    //             $this->organizers[] = new Organizer($organizer, $this);
    //         }
    //     }
    //     return $this->organizers;
    // }

    // public function getOrganizerForEvent(Event $event)
    // {

    // }

    // public function getEvents()
    // {
    //     if (count($this->events) == 0) {
    //         $events = parent::get($this->orgBase .'owned_events/', ['order_by' => 'start_desc']);
    //         $eventsReturn = $events['body']['events'];
    //         foreach ($eventsReturn as $event) {
    //             $this->events[] = new Event($event, $this);
    //         }            
    //     }
    //     return $this->events;
    // }

    // public function getUpcomingEventsForOrganizer($organizerId)
    // {
    //     // organizer_id: 10957647339
    //     // $organizerId = "10957647339";
    //     $events = parent::get('events/search/', ['organizer.id' => $organizerId]);
    //     $eventsReturn = $events['body']['events'];
    //     $organizerEvents = [];
    //     foreach ($eventsReturn as $event) {
    //         $organizerEvents[] = new Event($event, $this);
    //     }
    //     return $organizerEvents;
    // }

    // public function getPastEvents()
    // {
    //     // TODO: Implement
    // }
}
