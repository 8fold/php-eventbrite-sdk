<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\Core\ApiResource;

use Eightfold\Eventbrite\Classes\Event;
use Eightfold\Eventbrite\Classes\EventCollection;

use Eightfold\Eventbrite\Classes\Order;
use Eightfold\Eventbrite\Classes\OrderCollection;

use Eightfold\Eventbrite\Classes\Organizer;
use Eightfold\Eventbrite\Classes\OrganizerCollection;

use Eightfold\Eventbrite\Classes\Venue;
use Eightfold\Eventbrite\Classes\VenueCollection;

use Eightfold\Eventbrite\Classes\SubObjects\Attendee;
use Eightfold\Eventbrite\Classes\SubObjects\AttendeeCollection;

use Eightfold\Eventbrite\Classes\SubObjects\ContactList;
use Eightfold\Eventbrite\Classes\SubObjects\ContactListCollection;

use Eightfold\Eventbrite\Interfaces\ApiResourceInterface;
use Eightfold\Eventbrite\Interfaces\ApiResourceIsBase;
use Eightfold\Eventbrite\Interfaces\ApiResourcePostable;

/**
 * @package First order resource
 */
class User extends ApiResource
{
    private $id = 'me';

    private $me = null;

    private $upcomingEvents = null;

    private $orders = [];

    private $organizers = [];

    private $owned_events = [];

    private $events = [];

    private $venues = [];

    private $owned_event_attendees = [];

    private $owned_event_orders = [];

    private $contact_lists = null;

    public function __construct($client, $id)
    {
        $this->client = $client;
        $this->id = $id;
    }

    public function get()
    {
        if (is_null($this->me)) {
            $payload = $this->client->get('users/'. $this->id);
            parent::__construct($this->client, $payload);
            $this->me = $this;
        }
        return $this->me;
    }

    /**
     * GET /users/me/orders - Returns a paginated response of orders, under the key
     *                        orders, of all orders the user has placed (i.e. where
     *                        the user was the person buying the tickets).
     *
     * @return [type] [description]
     */
    public function orders($options = [])
    {
        $serialized = md5($this->id . serialize($options));
        if (!isset($this->orders[$serialized])) {
            $endpoint = 'users/'. $this->id .'/orders';
            $this->orders[$serialized] = new OrderCollection($this->client, $endpoint, $options);

        }
        return $this->orders[$serialized];
    }

    /**
     * GET /users/me/organizers - Returns a paginated response of organizer objects
     *                            that are owned by the user.
     *
     * @return [type] [description]
     */
    public function organizers()
    {
        if (count($this->organizers) == 0) {
            $endpoint = 'users/'. $this->id .'/organizers';
            $this->organizers = new OrganizerCollection($this->client, $endpoint);

        }
        return $this->organizers;
    }

    /**
     * GET /users/me/owned_events - Returns a paginated response of events, under the
     *                              key events, of all events the user owns (i.e.
     *                              events they are organising)
     *
     * @return [type] [description]
     */
    public function owned_events($options = ['order_by' => 'start_desc'])
    {
        $serialized = md5($this->id . serialize($options));
        if (!isset($this->owned_events[$serialized])) {
            $endpoint = 'users/'. $this->id .'/owned_events';
            $this->owned_events[$serialized] = new EventCollection($this->client, $endpoint, $options);

        }
        return $this->owned_events[$serialized];
    }

    /**
     * GET /users/me/events - Returns a paginated response of events, under the key
     *                    events, of all events the user has access to
     *
     * @return [type] [description]
     */
    public function events($options = ['order_by' => 'start_desc'])
    {
        $serialized = md5($this->id . serialize($options));
        if (!isset($this->events[$serialized])) {
            $endpoint = 'users/'. $this->id .'/events';
            $this->events[$serialized] = new EventCollection($this->client, $endpoint, $options);

        }
        return $this->events[$serialized];
    }

    /**
     * GET /users/:id/venues/ - Returns a paginated response of venue objects that are
     *                          owned by the user.
     *
     * @return [type] [description]
     */
    public function venues()
    {
        if (count($this->venues) == 0) {
            $endpoint = 'users/'. $this->id .'/venues';
            $this->venues = new VenueCollection($this->client, $endpoint);

        }
        return $this->venues;
    }

    /**
     * GET /users/:id/owned_event_attendees/ - Returns a paginated response of
     *                                         attendees, under the key attendees, of
     *                                         attendees visiting any of the events
     *                                         the user owns (events that would be
     *                                         returned from /users/:id/owned_events/)
     *
     * @return [type] [description]
     */
    public function owned_event_attendees()
    {
        if (count($this->owned_event_attendees) == 0) {
            $endpoint = 'users/'. $this->id .'/owned_event_attendees';
            $this->owned_event_attendees = new AttendeeCollection($this->client, $endpoint);

        }
        return $this->owned_event_attendees;
    }

    /**
     * GET /users/:id/owned_event_orders/ - Returns a paginated response of orders,
     *                                      under the key orders, of orders placed
     *                                      against any of the events the user owns (
     *                                      events that would be returned from /
     *                                      users/:id/owned_events/)
     *
     * @return [type] [description]
     */
    public function owned_event_orders($options = [])
    {
        $serialized = md5($this->id . serialize($options));
        if (!isset($this->owned_event_orders[$serialized])) {
            $endpoint = 'users/'. $this->id .'/owned_event_orders';
            $this->owned_event_orders[$serialized] = new OrderCollection($this->client, $endpoint, $options);

        }
        return $this->owned_event_orders[$serialized];
    }

    /**
     * GET /users/:id/contact_lists/ - Returns a list of contact_list that the user
     *                                 owns as the key contact_lists.
     *
     * @param  string $id [description]
     * @return [type]     [description]
     */
    public function contact_lists($id = '')
    {
        if (is_null($this->contact_lists)) {
            $endpoint = 'users/'. $this->id .'/contact_lists';
            $this->contact_lists = new ContactListCollection($this->client, $endpoint);

        }

        if (strlen($id) > 0) {
            return $this->contact_list($id);

        }
        return $this->contact_lists;
    }

    /**
     * GET /users/:id/contact_lists/:contact_list_id/ - Gets a user’s contact_list by
     *                                                  ID as contact_list.
     *
     * @param  string $id [description]
     * @return [type]     [description]
     *
     * @todo Not sure how to build contact list in Eventbrite; therefore, not sure how
     *       to test.
     */
    public function contact_list($id = '')
    {
        $contact_lists = $this->contact_lists();
        foreach ($contact_lists as $contact_list) {
            if ($contact_list->id == $id) {
                return $contact_list;
            }
        }
        return null;
    }

    /**
     * GET /users/:id/bookmarks/ - Gets all the user’s saved events. In order to
     *                             update the saved events list, the user must unsave
     *                             or save each event. A user is authorized to only
     *                             see his/her saved events.
     *
     * @return [type] [description]
     *
     * @todo Implement this functionality (need Bookmark and BookmarkCollection
     *       classes.)
     */
    public function bookmarks()
    {

    }
}
