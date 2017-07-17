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
        // okay to fail
        $event = $this->event();
        $ticketClasses = $event->ticket_classes;
        $expected = $ticketClasses[0];
        $result = $event->ticket_class($expected->id);
        $this->assertTrue($expected->id == '51941354', $expected->id);
        $this->assertNotNull($result);
        $this->assertEquality($expected->id, $result->id);
    }

    public function testEventQuestionsCannedQuestion()
    {
        $event = $this->event();
        $questions = $event->canned_questions;
        $this->assertTrue(count($questions) == 3, count($questions));
    }

    public function testEventQuestions()
    {
        $questions = $this->event()->questions;
        $this->assertTrue(count($questions) == 0, count($questions));
    }

    public function testEventAttendees()
    {
        $attendees = $this->event()->attendees;
        $this->assertTrue(count($attendees) == 0, count($attendees));
    }

    public function testEventOrders()
    {
        $orders = $this->event()->orders;
        $this->assertTrue(count($orders) == 0, count($orders));
    }

    public function testEventDiscounts()
    {
        $discounts = $this->event()->discounts;
        $this->assertTrue(count($discounts) == 0, count($discounts));
    }

    public function testEventPublicDiscounts()
    {
        $discounts = $this->event()->public_discounts;
        $this->assertTrue(count($discounts) == 0, count($discounts));
    }

    public function testEventAccessCodes()
    {
        $accessCodes = $this->event()->access_codes;
        $this->assertTrue(count($accessCodes) == 0, count($accessCodes));
    }

    public function testEventTransfers()
    {
        $result = $this->event()->transfers;
        $this->assertTrue(count($result) == 0, count($result));
    }
}
