<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\Core\ApiResource;

use Eightfold\Eventbrite\Classes\Event;
use Eightfold\Eventbrite\Classes\EventCollection;

use Eightfold\Eventbrite\Classes\Order;
use Eightfold\Eventbrite\Classes\UserSubs\Attendee;
use Eightfold\Eventbrite\Classes\UserSubs\ContactList;

use Eightfold\Eventbrite\Interfaces\ApiResourceInterface;
use Eightfold\Eventbrite\Interfaces\ApiResourceIsBase;
use Eightfold\Eventbrite\Interfaces\ApiResourcePostable;

/**
 * @package First order resource
 */
class User extends ApiResource
{

    private $events = null;

    private $upcomingEvents = null;

    /**
     * /users/me/orders - Returns a paginated response of orders, under the key 
     *                    orders, of all orders the user has placed (i.e. where the 
     *                    user was the person buying the tickets).
     *                    
     * @return [type] [description]
     */
    public function orders()
    {
        var_dump($this->client->get('users/me/orders'));
        // return $this->hasMany(Order::class, 'users/me/orders');
    }

    /**
     * /users/me/organizers - Returns a paginated response of organizer objects that 
     *                        are owned by the user.
     * 
     * @return [type] [description]
     */
    public function organizers()
    {
        // TODO: contact Eventbrite, does not appear to be working
        // TODO: passing in $id does not work as expected use organizers->where() instead        
        var_dump($this->client->get('users/me/organizers'));
        // return $this->hasMany(Organizer::class, 'users/me/organizers/'. $id);
    }

    /**
     * /users/me/owned_events - Returns a paginated response of events, under the key 
     *                          events, of all events the user owns (i.e. events they 
     *                          are organising)
     *                          
     * @return [type] [description]
     */
    public function owned_events($options = ['order_by' => 'start_desc'])
    {
        // TODO: Not returning in proper order. Endpoint is correct and works properly
        // when pasted into browser address bar. Does not work when using Postman nor
        // making the call from within the library        
        $payload = $this->client->get('users/me/owned_events', $options);
        return new EventCollection($this->client, $payload);
        return $collection;
    }

    /**
     * /users/me/events - Returns a paginated response of events, under the key 
     *                    events, of all events the user has access to
     *                    
     * @return [type] [description]
     */
    public function events($options = ['order_by' => 'start_desc'])
    {
        $payload = $this->client->get('users/me/events', $options);
        return new EventCollection($this->client, $payload);
    }

    public function venues()
    {
        return $this->hasMany(Venue::class, 'users/me/venues');
    }

    public function owned_event_attendees()
    {
        return $this->hasMany(Attendee::class, 'users/me/owned_event_attendees');
    }

    public function owned_event_orders()
    {
        return $this->hasMany(Order::class, 'users/me/owned_event_orders');
    }

    public function contact_lists($id = '')
    {
        return $this->hasMany(ContactList::class, 'users/me/contact_lists/'. $id);
    }
}
