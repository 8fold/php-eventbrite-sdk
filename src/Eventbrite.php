<?php

namespace Eightfold\Eventbrite;

use Eightfold\Eventbrite\Classes\Core\ApiClient as EventbriteBase;
use Eightfold\Eventbrite\Classes\Core\ApiCallBuilder;

use Eightfold\Eventbrite\Traits\Gettable;

use Eightfold\Eventbrite\Classes\Event;
use Eightfold\Eventbrite\Classes\User;
use Eightfold\Eventbrite\Classes\Category;
use Eightfold\Eventbrite\Classes\Organizer;
use Eightfold\Eventbrite\Classes\Format;

use Eightfold\Eventbrite\Classes\SubObjects\Organization;
use Eightfold\Eventbrite\Classes\SubObjects\Subcategory;
use Eightfold\Eventbrite\Classes\SubObjects\Attendee;
use Eightfold\Eventbrite\Classes\SubObjects\Sale;
use Eightfold\Eventbrite\Classes\SubObjects\Country;
use Eightfold\Eventbrite\Classes\SubObjects\Region;
use Eightfold\Eventbrite\Classes\SubObjects\Timezone;

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
        if (parent::canConnect()) {
            if ($isOrg) {
                $return = new ApiCallBuilder($this, Organization::class, 'users/me');
                $this->organization = $return->first();

            } else {
                $return = new ApiCallBuilder($this, User::class, 'users/me');
                $this->individual = $return->first();

            }            
        }
    }

    public function event($id = '')
    {
        return Event::find($this, Event::class, 'events/'. $id);
    }

    public function user()
    {
        if (is_null($this->organization)) {
            return $this->individual;
        }
        return $this->organization;
    }

    // TODO: Not sure how useful this is.
    public function reportAttendees()
    {
        return Attendee::find($this, Attendee::class, 'reports/attendees', [
            'event_status' => 'all'
        ]);
    }

    // TODO: Does not work with current Colleciton object.
    public function reportSales()
    {
        return Sale::find($this, Sale::class, 'reports/sales', [
            'event_status' => 'all'
        ]);
    }

    public function countries()
    {
        return Country::find($this, Country::class, 'system/countries');
    }

    public function regions()
    {
        return Region::find($this, Region::class, 'system/regions');
    }

    public function timezones()
    {
        return Timezone::find($this, Timezone::class, 'system/timezones');
    }

    public function categories($id = '')
    {
        $endpoint = (strlen($id) > 0)
            ? 'categories/'. $id
            : 'categories';
        return Category::find($this, Category::class, $endpoint);
    }

    public function subcategories($id = '')
    {
        $endpoint = (strlen($id) > 0)
            ? 'subcategories/'. $id
            : 'subcategories';
        return Subcategory::find($this, Subcategory::class, $endpoint);
    }

    public function formats($id = '')
    {
        $endpoint = (strlen($id) > 0)
            ? 'formats/'. $id
            : 'formats';
        return Format::find($this, Format::class, $endpoint);
    }
}
