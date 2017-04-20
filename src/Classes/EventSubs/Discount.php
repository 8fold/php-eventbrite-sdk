<?php

namespace Eightfold\Eventbrite\Classes\EventSubs;

use Eightfold\Eventbrite\Classes\Abstracts\EventSub;
use Eightfold\Eventbrite\Interfaces\EventSubInterface;

class Discount extends EventSub implements EventSubInterface
{
    protected function routeName()
    {
        return 'discounts';
    }
}