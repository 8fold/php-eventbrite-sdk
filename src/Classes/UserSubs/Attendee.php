<?php

namespace Eightfold\Eventbrite\Classes\UserSubs;

use Eightfold\Eventbrite\Classes\User;

use Eightfold\Eventbrite\Interfaces\ApiResourceInterface;

class Attendee implements ApiResourceInterface
{
    
    /**************/
    /* Interfaces */
    /**************/

    static public function expandedByDefault()
    {
        return [
            'event',
            'order',
            'promotional_code'
        ];
    }

    public function endpoint()
    {
        return null;
    }    

    static public function baseEndpoint()
    {
        return 'users';
    }

    static public function classPath()
    {
        return __CLASS__;
    }
}