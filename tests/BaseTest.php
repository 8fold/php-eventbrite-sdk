<?php
namespace Eightfold\Eventbrite\Tests;

use Eightfold\Eventbrite\Tests\HasTokens;

use Eightfold\Eventbrite\Eventbrite;

class BaseTest extends \PHPUnit_Framework_TestCase
{
    use HasTokens;

    protected function assertEquality($expected, $result)
    {
       $this->assertTrue($result == $expected, $expected ."\n\n". $result);
    }

    protected function eventbrite($isOrg = false)
    {
        return new Eventbrite($this->oauthToken, [], $isOrg);
    }

    protected function organization()
    {
        return $this->eventbrite(true)->me;
    }

    protected function event()
    {
        return $this->eventbrite(true)->event($this->eventId);
    }
}
