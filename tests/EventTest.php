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
}
