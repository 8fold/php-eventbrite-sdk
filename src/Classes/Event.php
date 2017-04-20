<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\ApiResource;

use Exception;

use GrahamCampbell\Markdown\Facades\Markdown;
use League\HTMLToMarkdown\HtmlConverter;

use Eightfold\Eventbrite\Eventbrite;

use Eightfold\Eventbrite\Classes\Venue;
use Eightfold\Eventbrite\Classes\Category;
use Eightfold\Eventbrite\Classes\TicketClass;
use Eightfold\Eventbrite\Classes\Discount;

use Eightfold\Eventbrite\Interfaces\ApiResourceInterface;
use Eightfold\Eventbrite\Interfaces\ApiResourceIsBase;
use Eightfold\Eventbrite\Interfaces\ApiResourcePostable;

use Eightfold\Eventbrite\Transformations\DateTransformations;

class Event extends ApiResource implements ApiResourceInterface, ApiResourceIsBase, ApiResourcePostable
{
    use DateTransformations;

    public function organizer()
    {
        return Organizer::find($this->eventbrite, $this->organizer_id);
    }

    public function venue()
    {
        return Venue::find($this->eventbrite, $this->venue_id);
    }

    public function category()
    {
        return Category::find($this->eventbrite, $this->category_id);
    }

    public function subcategory()
    {
        return Subcategory::find($this->eventbrite, $this->subcategory_id);
    }    

    public function htmlDescriptionClean()
    {
        // Plain text does not include the formatting allowed by Eventbrite.
        // Convert HTML to Markdown then back.
        $markdown = $this->htmlDescriptionToMarkdown();
        $html = Markdown::convertToHtml($markdown);
        return $html;
    }

    public function markdown()
    {
        return $this->htmlDescriptionToMarkdown();
    }

    private function htmlDescriptionToMarkdown()
    {
        $htmlConverter = new HtmlConverter();
        $markdown = $htmlConverter->convert($this->description->html);
        $markdownStripped = str_replace(['<span>', '</span>'], '', $markdown);
        return $markdownStripped;        
    }    



    public function ticketClasses($refresh = false)
    {
        $ticketClasses = TicketClass::all($this);
        return $ticketClasses;
    }

    public function ticketClassWithId(string $id)
    {
        return TicketClass::find($this, $id);
    }

    public function discounts($refresh = false)
    {
        $discounts = Discount::all($this);
        return $discounts;
    }

    public function discountWithId(string $id)
    {
        return Discount::find($this, $id);
    }

    public function lowCostDisplay()
    {
        return $this->lowestType->costDisplay();
    }    

    public function highCostDisplay()
    {
        return $this->highestType->costDisplay();
    }

    public function hasPriceRange()
    {
        return ($this->priceRange() > 0);
    }

    private function priceRange()
    {
        return $this->highCost() - $this->lowCost();
    }

    /**************/
    /* Interfaces */
    /**************/

    static public function baseEndpoint()
    {
        return 'events';
    }

    static public function classPath()
    {
        return __CLASS__;
    }

    public function endpoint()
    {
        return static::baseEndpoint() .'/'. $this->id;
    }      

    static public function parameterPrefix()
    {
        return 'event';
    }

    static public function parametersToPost()
    {
        return [
            'name_html', // .html
            'description_html', // .html
            'organizer_id',
            'start_utc', // .utc
            'start_timezone',
            'end_utc', // .utc
            'end_timezone',
            'hide_start_date',
            'hide_end_date',
            'currency',
            'venue_id',
            'online_event',
            'listed',
            'logo_id',
            'category_id',
            'subcategory_id',
            'format_id',
            'shareable',
            'invite_only',
            'password',
            'capacity',
            'show_remaining',
            'source',
            'status'
        ];
    }

    static public function parametersToConvertToDotNotation()
    {
        return [
            'name_html',
            'description_html',
            'end_utc',
            'end_timezone',
            'start_utc',
            'start_timezone'
        ];        
    }    
}