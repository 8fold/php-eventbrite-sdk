<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\Core\ApiResource;

class Category extends ApiResource
{
    // public function name()
    // {
    //     if (is_string($this->raw->name_localized)) {
    //         return $this->raw->name_localized;

    //     } elseif (isset($this->raw->name) && is_string($this->raw->name)) {
    //         return $this->raw->name;

    //     }
    //     return null;
    // }

    // public function short_name()
    // {
    //     if (isset($this->raw->short_name_localized) && is_string($this->raw->short_name_localized)) {
    //         return $this->raw->short_name_localized;

    //     } elseif (isset($this->raw->short_name) && is_string($this->raw->short_name)) {
    //         return $this->raw->short_name;

    //     } else {
    //         return $this->name;

    //     }
    // }
}
