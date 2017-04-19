<?php

namespace Eightfold\Eventbrite\Traits;

trait ClassMappable
{
    /**
     * Maps API endpoints with classes
     *
     * 
     * @var dictionary
     */
    private $classMap = [
        'users'  => 'Eightfold\Eventbrite\Classes\Individual',
        'events' => 'Eightfold\Eventbrite\Classes\Event',
        'categories' => 'Eightfold\Eventbrite\Classes\Category',
        'subcategories' => 'Eightfold\Eventbrite\Classes\Subcategory',
        'ticket_classes' => 'Eightfold\Eventbrite\Classes\TicketClass'
    ];
}