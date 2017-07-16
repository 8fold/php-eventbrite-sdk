<?php
namespace Eightfold\Eventbrite\Tests;

use Eightfold\Eventbrite\Tests\BaseTest;

use Eightfold\Eventbrite\Eventbrite;

use Eightfold\Eventbrite\Classes\User;
use Eightfold\Eventbrite\Classes\Event;

use Eightfold\Eventbrite\Classes\SubObjects\Organization;

class EventbriteTest extends BaseTest
{
    public function testEventbriteInitialization()
    {
        $eventbriteStatic = Eventbrite::connect($this->oauthToken);
        $this->assertNotNull($eventbriteStatic);

        $eventbrite = $this->eventbrite();
        $this->assertNotNull($eventbrite);
    }

    public function testEventbriteUser()
    {
        $user = $this->eventbrite()->me;
        $this->assertNotNull($user);
    }

    public function testEventbriteUserIsIndividual()
    {
        $individual = $this->eventbrite()->me;
        $this->assertTrue(get_class($individual) == User::class, get_class($individual));
    }

    public function testEventbriteUserIsOrganization()
    {
        $organization = $this->organization();
        $this->assertTrue(get_class($organization) == Organization::class, get_class($organization));
    }

    public function testEventbriteUserHasOwnedEvents()
    {
        $ownedEvents = $this->organization()->owned_events;
        $this->assertTrue(count($ownedEvents) > 0);
    }

    public function testEventbriteEventExists()
    {
        $event = $this->event();
        $this->assertNotNull($event);
    }

    public function testEventbriteEventIsEvent()
    {
        $events = $this->eventbrite(true)->my->owned_events;
        $this->assertTrue(count($events) == 8, count($events));

        $event = $events[0];
        $this->assertTrue(get_class($event) == Event::class, get_class($event));
    }

    public function testEventbriteEventTitle()
    {
        $event = $this->event();
        $this->assertTrue('Agile Fundamentals (ICAgile Accredited)' == $event->name->text, $event->name->text);
    }
}
