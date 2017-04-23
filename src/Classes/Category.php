<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\Core\ApiResource;

class Category extends ApiResource
{
    public function name()
    {
        if (is_string($this->name_localized)) {
            return $this->name_localized;

        } elseif (is_string($this->name)) {
            return $this->name;

        }
        return null;
    }

    public function shortName()
    {
        if (is_string($this->short_name_localized)) {
            return $this->short_name_localized;

        } elseif (is_string($this->short_name)) {
            return $this->short_name;

        } else {
            return $this->name;

        }
    }    
}