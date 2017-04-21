<?php

namespace Eightfold\Eventbrite\Classes\EventSubs;

use Eightfold\Eventbrite\Classes\Abstracts\EventSub;
use Eightfold\Eventbrite\Interfaces\EventSubInterface;

class Discount extends EventSub implements EventSubInterface
{
    static public function routeName()
    {
        return 'discounts';
    }

    static public function classPath()
    {
        return __CLASS__;
    }

    public function endpoint()
    {
        return $this->event()->endpoint .'/discounts/'. $this->id;
    }

    static public function parameterPrefix()
    {
        return 'discount';
    }

    static public function parametersToPost()
    {
        return [];
    }

    static public function parametersToConvertToDotNotation()
    {
        return [];
    }
}