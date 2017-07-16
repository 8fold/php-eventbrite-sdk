<?php
namespace Eightfold\Eventbrite\Tests;

use Eightfold\Eventbrite\Tests\HasTokens;

class BaseTest extends \PHPUnit_Framework_TestCase
{
    use HasTokens;

    protected function assertEquality($expected, $result)
    {
       $this->assertTrue($result == $expected, $expected ."\n\n". $result);
    }
}
