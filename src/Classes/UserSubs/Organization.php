<?php

namespace Eightfold\Eventbrite\Classes\UserSubs;

use Eightfold\Eventbrite\Classes\User;

use Eightfold\Eventbrite\Interfaces\ApiResourceInterface;

class Organization extends User implements ApiResourceInterface
{
    
    /**************/
    /* Interfaces */
    /**************/

    static public function baseEndpoint()
    {
        return 'users';
    }

    static public function classPath()
    {
        return __CLASS__;
    }
}