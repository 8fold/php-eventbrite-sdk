<?php

namespace Eightfold\Eventbrite\Classes\EventSubs;

use Eightfold\Eventbrite\Classes\Abstracts\EventSub;
use Eightfold\Eventbrite\Interfaces\EventSubInterface;

class DisplaySetting extends EventSub implements EventSubInterface
{
    /**************/
    /* Interfaces */
    /**************/
    static public function routeName()
    {
        return 'display_settings';
    }
    
    static public function classPath()
    {
        return __CLASS__;
    }

    public function endpoint()
    {
        return $this->event()->endpoint .'/ticket_classes/'. $this->id;
    }

    static public function parameterPrefix()
    {
        return 'ticket_class';
    }

    static public function parametersToPost()
    {
        return [
            'name',
            'description',
            'quantity_total',
            'cost',
            'donation',
            'free',
            'include_fee',
            'split_fee',
            'hide_description',
            'sales_channels',
            'sales_start',
            'sales_end',
            'sales_start_after',
            'minimum_quantity',
            'maximum_quantity',
            'auto_hide',
            'auto_hide_before',
            'auto_hide_after',
            'hidden',
            'order_confirmation_message'
        ];
    }

    static public function parametersToConvertToDotNotation()
    {
        return [];
    }    
}