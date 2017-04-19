<?php

namespace Eightfold\Eventbrite\Traits;

trait ClassMappable
{
    /**
     * Maps endpoint start with package class to return instance
     * @var dictionary
     */
    private $classMap = [
        'users'  => 'Eightfold\Eventbrite\Classes\Individual',
        'events' => 'Eightfold\Eventbrite\Classes\Event',
        'categories' => 'Eightfold\Eventbrite\Classes\Category',
        'subcategories' => 'Eightfold\Eventbrite\Classes\Subcategory'
    ];
}