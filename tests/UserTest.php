<?php
namespace Eightfold\Eventbrite\Tests;

use Eightfold\Eventbrite\Tests\BaseTest;

use Eightfold\Eventbrite\Eventbrite;

use Eightfold\Eventbrite\Classes\User;
use Eightfold\Eventbrite\Classes\Organizer;
use Eightfold\Eventbrite\Classes\Order;
use Eightfold\Eventbrite\Classes\SubObjects\Attendee;

class UserTest extends BaseTest
{
    public function testUserOrders()
    {
        $user = $this->organization();
        $this->assertTrue(count($user->orders) == 0, count($user->orders));
    }

    public function testUserOrganizers()
    {
        $user = $this->organization();
        $this->assertTrue(count($user->organizers) == 4, count($user->organizers));
    }

    public function testUserOrganizersIsOrganizer()
    {
        $organizers = $this->organization()->organizers;
        $organizer = $organizers[0];
        $this->assertTrue(get_class($organizer) == Organizer::class, get_class($organizer));
    }

    public function testUserOrganizersFromGet()
    {
        $user = $this->organization();
        $email = $user->get->name;
        $this->assertTrue($this->emailAddress == $email, $email);
    }

    public function testUserOwnedEvents()
    {
        $ownedEvents = $this->organization()->owned_events;
        $this->assertTrue(count($ownedEvents) == 8, count($ownedEvents));
    }

    public function testUserEvents()
    {
        $events = $this->organization()->events;
        $this->assertTrue(count($events) == 8, count($events));
    }

    public function testUserVenues()
    {
        $venues = $this->organization()->venues;
        $this->assertTrue(count($venues) == 17, count($venues));
    }

    public function testUserOwnedEventAttendees()
    {
        $attendees = $this->organization()->owned_event_attendees;
        $this->assertTrue(count($attendees) == 45, count($attendees));
    }

    public function testUserOwnedEventAttendeesIsAttendee()
    {
        $attendees = $this->organization()->owned_event_attendees;
        $attendee = $attendees[0];
        $this->assertTrue(get_class($attendee) == Attendee::class, get_class($attendee));
    }

    public function testUserOwnedEventOrders()
    {
        $orders = $this->organization()->owned_event_orders;
        $this->assertTrue(count($orders) == 28, count($orders));
    }

    public function testUserOwnedEventOrdersIsOrder()
    {
        $orders = $this->organization()->owned_event_orders;
        $order = $orders[0];
        $this->assertTrue(get_class($order) == Order::class, get_class($order));
    }

    public function testUserContactLists()
    {
        $contactLists = $this->organization()->contact_lists;
        $this->assertTrue(count($contactLists) == 0, count($contactLists));
    }
}
