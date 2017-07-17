<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\Core\ApiResource;

use Eightfold\Eventbrite\Classes\EventCollection;
use Eightfold\Eventbrite\Classes\OrganizerCollection;
use Eightfold\Eventbrite\Classes\VenueCollection;
use Eightfold\Eventbrite\Classes\SubObjects\AttendeeCollection;
use Eightfold\Eventbrite\Classes\SubObjects\ContactListCollection;

/**
 * @package First order resource
 */
class User extends ApiResource
{
    private $upcomingEvents = null;

    private $orders = [];

    private $organizers = [];

    private $owned_events = [];

    private $events = [];

    private $venues = [];

    private $owned_event_attendees = [];

    private $owned_event_orders = [];

    private $contact_lists = null;

    public function __construct($client, $idOrPayload = 'me')
    {
        $this->client = $client;

        if (is_string($idOrPayload)) {
            $this->id = $idOrPayload;

        } else {
            $this->id = isset($idOrPayload['id'])
                ? $idOrPayload['id']
                : $idOrPayload;
            parent::__construct($client, $idOrPayload);

        }
        $this->endpoint = 'users/'. $this->id;
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
        return $this->property($this->id . serialize($options), 'orders', OrderCollection::class, $options);
    }

    /**
     * GET /users/me/organizers - Returns a paginated response of organizer objects
     *                            that are owned by the user.
     *
     * @return [type] [description]
     */
    public function organizers()
    {
        return $this->property($this->id, 'organizers', OrganizerCollection::class);
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
        return $this->property($this->id . serialize($options), 'owned_events', EventCollection::class, $options);
    }

    /**
     * GET /users/me/events - Returns a paginated response of events, under the key
     *                    events, of all events the user has access to
     *
     * @return [type] [description]
     */
    public function events($options = ['order_by' => 'start_desc'])
    {
        return $this->property($this->id . serialize($options), 'events', EventCollection::class);
    }

    /**
     * GET /users/:id/venues/ - Returns a paginated response of venue objects that are
     *                          owned by the user.
     *
     * @return [type] [description]
     */
    public function venues()
    {
        return $this->property($this->id, 'venues', VenueCollection::class);
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
        return $this->property($this->id, 'owned_event_attendees', AttendeeCollection::class);
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
        return $this->property($this->id . serialize($options), 'owned_event_orders', OrderCollection::class);
    }

    /**
     * GET /users/:id/contact_lists/ - Returns a list of contact_list that the user
     *                                 owns as the key contact_lists.
     *
     * @param  string $id [description]
     * @return [type]     [description]
     */
    public function contact_lists()
    {
        return $this->property($this->id, 'contact_lists', ContactListCollection::class);
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
