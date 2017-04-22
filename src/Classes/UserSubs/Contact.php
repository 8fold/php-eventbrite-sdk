<?php

namespace Eightfold\Eventbrite\Classes\UserSubs;

use Eightfold\Eventbrite\Interfaces\ApiResourceInterface;

class Contact implements ApiResourceInterface
{
    
    /**************/
    /* Interfaces */
    /**************/

    static public function expandedByDefault()
    {
        return [];
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