<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\ApiResource;
use Eightfold\Eventbrite\Interfaces\ApiResourceInterface;
use Eightfold\Eventbrite\Interfaces\ApiResourcePostable;

use Eightfold\Eventbrite\Classes\Event;

use Eightfold\Eventbrite\Traits\Gettable;

class Discount extends ApiResource implements ApiResourceInterface, ApiResourcePostable
{
    use Gettable;

    private $myEvent;

    static public function all(Event $event)
    {
        $eventbrite = $event->eventbrite;
        $baseEndpoint = $event->endpoint() .'/discounts';
        $ticketClasses = parent::getMany($event->eventbrite, $baseEndpoint);
        return $ticketClasses;
    }

    static public function find($event, string $id)
    {
        $endpoint = $event->endpoint .'/discounts/'. $id;
        return $event->eventbrite->get($endpoint, [], __CLASS__);
    }

    public function event()
    {
        if (is_null($this->myEvent)) {
            $this->myEvent = Event::find($this->eventbrite, $this->event_id);
        }
        return $this->myEvent;
    }

    public function ticketClasses()
    {
        return $this->ticket_ids;
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
        return $this->event()->endpoint .'/discounts/'. $this->id;
    }

    static public function parameterPrefix()
    {
        return 'discount';
    }

    static public function parametersToPost()
    {
        return [
            'code',
            'amount_off',
            'percent_off',
            'ticket_ids',
            'quantity_available',
            'start_date',
            'end_date'
        ];
    }

    static public function parametersToConvertToDotNotation()
    {
        return [];
    }
}