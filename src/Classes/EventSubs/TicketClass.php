<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\ApiResource;
use Eightfold\Eventbrite\Interfaces\ApiResourceInterface;
use Eightfold\Eventbrite\Interfaces\ApiResourcePostable;

use Eightfold\Eventbrite\Classes\Event;

use Eightfold\Eventbrite\Traits\Gettable;

class TicketClass extends ApiResource implements ApiResourceInterface, ApiResourcePostable
{
    use Gettable;

    private $myEvent;

    static public function all(Event $event)
    {
        $eventbrite = $event->eventbrite;
        $baseEndpoint = $event->endpoint() .'/ticket_classes';
        $ticketClasses = parent::getMany($event->eventbrite, $baseEndpoint);
        return $ticketClasses;
    }

    static public function find($event, string $id)
    {
        $endpoint = $event->endpoint .'/ticket_classes/'. $id;
        return $event->eventbrite->get($endpoint, [], __CLASS__);
    }

    public function event()
    {
        if (is_null($this->myEvent)) {
            $this->myEvent = Event::find($this->eventbrite, $this->event_id);
        }
        return $this->myEvent;
    }

    public function setCost(int $value, string $currency = null, string $display = null)
    {
        $this->changed['cost'] = 'USD,'. $value;
    }

    public function getCost()
    {
        return $this->cost['value'];
    }

    public function getCostDisplay()
    {
        return $this->cost['display'];
    }

    /**************/
    /* Interfaces */
    /**************/

    static public function classPath()
    {
        return __CLASS__;
    }

    public function endpoint()
    {
        return $this->event()->endpoint .'/ticket_classes/'. $this->id;
    }

    static public function parameterPrefix()
    {
        return 'ticket_class';
    }

    static public function parametersToPost()
    {
        return [
            'name',
            'description',
            'quantity_total',
            'cost',
            'donation',
            'free',
            'include_fee',
            'split_fee',
            'hide_description',
            'sales_channels',
            'sales_start',
            'sales_end',
            'sales_start_after',
            'minimum_quantity',
            'maximum_quantity',
            'auto_hide',
            'auto_hide_before',
            'auto_hide_after',
            'hidden',
            'order_confirmation_message'
        ];
    }

    static public function parametersToConvertToDotNotation()
    {
        return [];
    }
}