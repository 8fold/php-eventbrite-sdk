<?php

// inspired by jamiehollern/eventbrite
namespace Eightfold\Eventbrite;

use Eightfold\Eventbrite\Classes\Abstracts\ApiClient as EventbriteBase;
use Eightfold\Eventbrite\Classes\Abstracts\ApiCallBuilder;

use Eightfold\Eventbrite\Traits\Gettable;

use Eightfold\Eventbrite\Classes\User;
use Eightfold\Eventbrite\Classes\UserSubs\Organization;
use Eightfold\Eventbrite\Classes\Organizer;
use Eightfold\Eventbrite\Classes\Event;
use Eightfold\Eventbrite\Classes\System\Timezone;
use Eightfold\Eventbrite\Classes\System\Region;
use Eightfold\Eventbrite\Classes\System\Country;
use Eightfold\Eventbrite\Classes\Reports\Sales;
use Eightfold\Eventbrite\Classes\Reports\Attendees;

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

    /**
     * Each Eventbrite client is associated with a user. The default is a human;
     * however, it is possible you want it to be an organization (the main account),
     * this distinguishes between those two things.
     * 
     * @var Eightfold\Classes\Organization
     */
    private $organization = null;

    /**
     * See `$organization`. This is a human instance of the Eventbrite API client.
     * 
     * @var Eightfold\Classes\Individual
     */
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
        if ($this->canConnect()) {
            if ($isOrg) {
                $return = new ApiCallBuilder($this, Organization::class, 'users/me');
                $this->organization = $return->first();

            } else {
                $return = new ApiCallBuilder($this, User::class, 'users/me');
                $this->individual = $return->first();

            }            
        }
    }

    /**
     * Shorthand for getting the events from the individual or ogranization.
     * 
     * @return Collection The collection of the Events found for the individual or
     *                    organization.
     */
    public function myEvents()
    {
        return $this->user->events;
    }

    /**
     * Shorthand for getting the upcoming events from the individual or ogranization.
     * 
     * @return Collection The collection of the Events found for the individual or
     *                    organization.
     */
    public function myUpcomingEvents()
    {
        return $this->user->upcomingEvents;
    }    

    /**
     * The account associated with this Eventbrite API connection.
     * 
     * @return Organization|Individual The object associated with the token used to
     *                                 to instantiate the Eventbrite connection.
     */
    public function user()
    {
        if (is_null($this->organization)) {
            return $this->individual;
        }
        return $this->organization;
    }

    public function timezones()
    {
        return Timezone::all($this);
    }

    public function countries()
    {
        return Country::all($this);
    }

    public function regions()
    {
        return Region::all($this);
    }

    public function sales()
    {
        return Sales::get($this);
    }

    public function attendees()
    {
        return Attendees::get($this);
    }
}
