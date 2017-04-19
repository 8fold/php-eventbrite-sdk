<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\Individual;

use Eightfold\Eventbrite\Interfaces\ApiResourceInterface;

class Organization extends Individual implements ApiResourceInterface
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