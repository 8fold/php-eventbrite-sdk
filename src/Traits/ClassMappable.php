<?php

namespace Eightfold\Eventbrite\Traits;

trait ClassMappable
{
    /**
     * @deprecated
     * 
     * Maps API endpoints with classes
     *
     * 
     * @var dictionary
     */
    private $classMap = [
        'users'              => 'Eightfold\Eventbrite\Classes\User',
        'events'             => 'Eightfold\Eventbrite\Classes\Event',
        'orders'             => 'Eightfold\Eventbrite\Classes\Order',
        'owned_event_orders' => 'Eightfold\Eventbrite\Classes\Order',
        'categories'         => 'Eightfold\Eventbrite\Classes\Category',
        'venues'             => 'Eightfold\Eventbrite\Classes\Venue',
        'subcategories'      => 'Eightfold\Eventbrite\Classes\SubObjects\Subcategory',
        'ticket_classes'     => 'Eightfold\Eventbrite\Classes\SubObjects\TicketClass',
        'attendees'          => 'Eightfold\Eventbrite\Classes\SubObjects\Attendee',
        'discounts'          => 'Eightfold\Eventbrite\Classes\SubObjects\Discount',
        'display_settings'   => 'Eightfold\Eventbrite\Classes\SubObjects\DisplaySetting',
        'access_codes'       => 'Eightfold\Eventbrite\Classes\SubObjects\AccessCode',
        'timezones'          => 'Eightfold\Eventbrite\Classes\SubObjects\Timezone',
        'regions'            => 'Eightfold\Eventbrite\Classes\SubObjects\Region',
        'countries'          => 'Eightfold\Eventbrite\Classes\SubObjects\Country',
        'sales'              => 'Eightfold\Eventbrite\Classes\SubObjects\Sale',
        'questions'          => 'Eightfold\Eventbrite\Classes\SubObjects\Question'
    ];
}