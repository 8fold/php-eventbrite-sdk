<?php

namespace Eightfold\Eventbrite\Classes\CategorySub;

use Eightfold\Eventbrite\Classes\Category;

class Subcategory extends Category
{
    /**************/
    /* Interfaces */
    /**************/

    static public function baseEndpoint()
    {
        return 'subcategories';
    }

    static public function classPath()
    {
        return __CLASS__;
    }

    public function endpoint()
    {
        return static::baseEndpoint() .'/'. $this->id;
    }        
}