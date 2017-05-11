<?php

namespace Eightfold\Eventbrite\Classes\SubObjects;

use Eightfold\Eventbrite\Classes\SubObjects\EventSub;

use Eightfold\Eventbrite\Interfaces\ExpandableInterface;

/**
 * @package EventSub alias
 */
class Attendee extends EventSub implements ExpandableInterface
{
    static public function expandedByDefault()
    {
        return [
            'event',
            'order',
            'promotional_code'
        ];
    }
}
