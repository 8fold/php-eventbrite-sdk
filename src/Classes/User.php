<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\Core\ApiResource;

use Eightfold\Eventbrite\Classes\Event;
use Eightfold\Eventbrite\Classes\Order;
use Eightfold\Eventbrite\Classes\UserSubs\Attendee;
use Eightfold\Eventbrite\Classes\UserSubs\ContactList;

use Eightfold\Eventbrite\Interfaces\ApiResourceInterface;
use Eightfold\Eventbrite\Interfaces\ApiResourceIsBase;
use Eightfold\Eventbrite\Interfaces\ApiResourcePostable;

class User extends ApiResource
{
    
    private $events = null;

    private $upcomingEvents = null;

    public function orders()
    {
        return $this->hasMany(Order::class, 'users/me/orders');
    }

    // TODO: contact Eventbrite, does not appear to be working
    // TODO: passing in $id does not work as expected use organizers->where() instead
    public function organizers($id = '')
    {
        return $this->hasMany(Organizer::class, 'users/me/organizers/'. $id);
    }

    public function owned_events()
    {
        // TODO: Not returning in proper order. Endpoint is correct and works properly
        // when pasted into browser address bar. Does not work when using Postman nor
        // making the call from within the library:
        // https://www.eventbriteapi.com/v3/users/me/owned_events/
        // ?token=V75CULK7QRW5JDJ7TLQO&order_by=start_desc
        return $this->hasMany(
            Event::class, 
            'users/me/owned_events', 
            [
                'order_by' => 'start_desc'
            ]
        );
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'users/me/events', [
            'order_by' => 'start_desc'
        ], 
        'events',
        ['pagination']);
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