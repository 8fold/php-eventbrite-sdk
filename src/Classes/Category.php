<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\ApiResource;

use Eightfold\Eventbrite\Interfaces\ApiResourceInterface;
use Eightfold\Eventbrite\Interfaces\ApiResourceIsBase;

class Category extends ApiResource implements ApiResourceInterface, ApiResourceIsBase
{
    public function name()
    {
        if (isset($this->name_localized)) {
            return $this->name_localized;

        } elseif (isset($this->name)) {
            return $this->name;

        }
        return null;
    }

    public function shortName()
    {
        if (isset($this->short_name_localized)) {
            return $this->short_name_localized;

        } elseif (isset($this->short_name)) {
            return $this->short_name;

        } else {
            return $this->name;

        }
    }

    /**************/
    /* Interfaces */
    /**************/

    static public function baseEndpoint()
    {
        return 'categories';
    }

    static public function classPath()
    {
        return __CLASS__;
    }
}