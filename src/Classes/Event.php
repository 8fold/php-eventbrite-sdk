<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\ApiResource;

use Exception;

use Eightfold\Eventbrite\Eventbrite;

use Eightfold\Eventbrite\Classes\Venue;
use Eightfold\Eventbrite\Classes\Category;
use Eightfold\Eventbrite\Classes\TicketClass;

use GrahamCampbell\Markdown\Facades\Markdown;
use League\HTMLToMarkdown\HtmlConverter;

use Eightfold\Eventbrite\Transformations\DateTransformations;

class Event extends ApiResource
{
    use DateTransformations;

    /**
     * REQUIRED: Defines the base endpoint for the resource.
     */
    const endpointEntry = 'events/';
    const classPath = __CLASS__;
    const postKey = 'event';
    const settableFields = [
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
        'source'
    ];

    const convertToDots = [
        'name_html',
        'description_html',
        'end_utc',
        'end_timezone',
        'start_utc',
        'start_timezone'
    ];

    public function organizer()
    {
        return Organizer::find($this->organizer_id, $this->eventbrite);
    }

    public function venue()
    {
        return Venue::find($this->venue_id, $this->eventbrite);
    }

    public function category()
    {
        return Category::find($this->category_id, $this->eventbrite);
    }

    public function htmlDescription()
    {
        // Plain text does not include the formatting allowed by Eventbrite.
        // Convert HTML to Markdown then back.
        $htmlConverter = new HtmlConverter();
        $markdown = $htmlConverter->convert($this->description['html']);
        $markdownStripped = str_replace(['<span>', '</span>'], '', $markdown);
        $html = Markdown::convertToHtml($markdownStripped);
        return $html;
    }

    public function subcategory()
    {
        return $this->subcategory;
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
}