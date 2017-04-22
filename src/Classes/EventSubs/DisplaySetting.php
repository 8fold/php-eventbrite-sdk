<?php

namespace Eightfold\Eventbrite\Classes\EventSubs;

use Eightfold\Eventbrite\Classes\Abstracts\EventSub;
use Eightfold\Eventbrite\Interfaces\EventSubInterface;

class DisplaySetting extends EventSub implements EventSubInterface
{
    /**************/
    /* Interfaces */
    /**************/

    static public function expandedByDefault()
    {
        return [];
    }

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
            'show_start_date',
            'show_end_date',
            'show_start_end_time',
            'show_timezone', 
            'show_map',
            'show_remaining',
            'show_organizer_facebook',
            'show_organizer_twitter',
            'show_facebook_friends_going',
            'terminology'
        ];
    }

    static public function parametersToConvertToDotNotation()
    {
        return [];
    }    
}