<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\ApiResource;

class Category extends ApiResource
{
    public function getName()
    {
        if (isset($this->name_localized)) {
            return $this->name_localized;

        } elseif (isset($this->name)) {
            return $this->name;

        }
        return null;
    }

    public function getShortName()
    {
        if (isset($this->short_name_localized)) {
            return $this->short_name_localized;

        } elseif (isset($this->short_name)) {
            return $this->short_name;

        } else {
            return $this->getName();

        }
    }
}