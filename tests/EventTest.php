<?php
namespace Eightfold\Eventbrite\Tests;

use Eightfold\Eventbrite\Tests\BaseTest;

use Eightfold\Eventbrite\Eventbrite;

use Eightfold\Eventbrite\Classes\Event;

class EventTest extends BaseTest
{
    public function testEventDisplaySettings()
    {
        $event = $this->event();
        $displaySettings = $event->display_settings;
        $this->assertTrue(count($displaySettings) == 1, count($displaySettings));
    }

    public function testEventTicketClasses()
    {
        $event = $this->event();
        $ticketClasses = $event->ticket_classes;
        $this->assertTrue(count($ticketClasses) == 1, count($ticketClasses));
    }

    public function testEventTicketClassWithId()
    {
        $event = $this->event();
        $ticketClasses = $event->ticket_classes;
        $expected = $ticketClasses[0];
        $result = $event->ticket_class($expected->id);
        $this->assertTrue($expected->id == '51941354', $expected->id);
        $this->assertNotNull($result);
        $this->assertEquality($expected->id, $result->id);
    }
}
