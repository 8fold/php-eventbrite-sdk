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
        'users'              => 'Eightfold\Eventbrite\Classes\User',
        'events'             => 'Eightfold\Eventbrite\Classes\Event',
        'orders'             => 'Eightfold\Eventbrite\Classes\Order',
        'owned_event_orders' => 'Eightfold\Eventbrite\Classes\Order',
        'categories'         => 'Eightfold\Eventbrite\Classes\Category',
        'venues'             => 'Eightfold\Eventbrite\Classes\Venue',
        'subcategories'      => 'Eightfold\Eventbrite\Classes\Subcategory',
        'ticket_classes'     => 'Eightfold\Eventbrite\Classes\EventSubs\TicketClass',
        'attendees'          => 'Eightfold\Eventbrite\Classes\EventSubs\Attendee',
        'discounts'          => 'Eightfold\Eventbrite\Classes\EventSubs\Discount',
        'display_settings'   => 'Eightfold\Eventbrite\Classes\EventSubs\DisplaySetting',
        'access_codes'       => 'Eightfold\Eventbrite\Classes\EventSubs\AccessCode',
        'timezones'          => 'Eightfold\Eventbrite\Classes\System\Timezone',
        'regions'            => 'Eightfold\Eventbrite\Classes\System\Region',
        'countries'          => 'Eightfold\Eventbrite\Classes\System\Country',
        'sales'              => 'Eightfold\Eventbrite\Classes\Reports\Sale',
        'questions'          => 'Eightfold\Eventbrite\Classes\EventSubs\Question'
    ];
}