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
        'ticket_classes' => 'Eightfold\Eventbrite\Classes\TicketClass',
        'discounts' => 'Eightfold\Eventbrite\Classes\Discount',
        'display_settings' => 'Eightfold\Eventbrite\Classes\DisplaySetting',
        'timezones' => 'Eightfold\Eventbrite\Classes\System\Timezone',
        'regions' => 'Eightfold\Eventbrite\Classes\System\Region',
        'countries' => 'Eightfold\Eventbrite\Classes\System\Country',
        'sales' => 'Eightfold\Eventbrite\Classes\Reports\Sale'
    ];
}