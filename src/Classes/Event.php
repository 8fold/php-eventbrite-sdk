<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\Core\ApiResource;

use Exception;

use Eightfold\Eventbrite\Classes\Order;
use Eightfold\Eventbrite\Classes\Organizer;
use Eightfold\Eventbrite\Classes\Venue;
use Eightfold\Eventbrite\Classes\Category;
use Eightfold\Eventbrite\Classes\Format;
use Eightfold\Eventbrite\Classes\Media;

use Eightfold\Eventbrite\Classes\SubObjects\DisplaySetting;
use Eightfold\Eventbrite\Classes\SubObjects\TicketClass;
use Eightfold\Eventbrite\Classes\SubObjects\Question;
use Eightfold\Eventbrite\Classes\SubObjects\Attendee;
use Eightfold\Eventbrite\Classes\SubObjects\Discount;
use Eightfold\Eventbrite\Classes\SubObjects\AccessCode;
use Eightfold\Eventbrite\Classes\SubObjects\Transfer;
use Eightfold\Eventbrite\Classes\SubObjects\Team;
use Eightfold\Eventbrite\Classes\SubObjects\Subcategory;

use GrahamCampbell\Markdown\Facades\Markdown;
use League\HTMLToMarkdown\HtmlConverter;

use Eightfold\Eventbrite\Transformations\DateTransformations;

/**
 * An event stored in Eventbrite.
 *
 * @package First order resource
 */
class Event extends ApiResource
{
    // TODO: Verify still using
    use DateTransformations;

    /**
     * The display settings for the Event
     *
     * @return Eightfold\Eventbrite\Classes\SubObjects\DisplaySetting
     */
    public function display_settings()
    {
        $endpoint = $this->endpoint .'/display_settings';
        return $this->hasOne(DisplaySetting::class, $endpoint);
    }

    /**
     * [ticket_classes description]
     * @param  string $id [description]
     * @return [type]     [description]
     */
    public function ticket_classes($id = '')
    {
        $endpoint = (strlen($id) > 0)
            ? $this->endpoint .'/ticket_classes/'. $id
            : $this->endpoint .'/ticket_classes';
        return $this->hasMany(TicketClass::class, $endpoint);
    }

    // TODO: Revisit - might need to be its own class
    public function canned_questions()
    {
        $endpoint = $this->endpoint .'/canned_questions';
        return $this->hasMany(Question::class, $endpoint);
    }

    public function questions($id = '')
    {
        $endpoint = (strlen($id) > 0)
            ? $this->endpoint .'/questions/'. $id
            : $this->endpoint .'/questions';
        return $this->hasMany(Question::class, $endpoint);
    }

    // TODO: See display_settings
    public function attendees($id = '')
    {
        $endpoint = $this->endpoint .'/attendees/'. $id;
        return $this->hasMany(Attendee::class, $endpoint);
    }

    public function orders()
    {
        $endpoint = $this->endpoint .'/orders';
        return $this->hasMany(Order::class, $endpoint);
    }

    public function discounts($id = '')
    {
        $endpoint = $this->endpoint .'/discounts/'. $id;
        return $this->hasMany(Discount::class, $endpoint);
    }

    public function public_discounts($id = '')
    {
        $endpoint = $this->endpoint .'/public_discounts/'. $id;
        return $this->hasMany(Discount::class, $endpoint);
    }

    public function access_codes($id = '')
    {
        $endpoint = $this->endpoint .'/access_codes/'. $id;
        return $this->hasMany(AccessCode::class, $endpoint);
    }

    public function transfers()
    {
        $endpoint = $this->endpoint .'/transfers';
        return $this->hasMany(Transfer::class, $endpoint);
    }

    public function teams($id = '')
    {
        $endpoint = $this->endpoint .'/teams/'. $id;
        return $this->hasMany(Team::class, $endpoint);
    }

    public function organizer()
    {
        $endpoint = 'organizers/'. $this->organizer_id;
        return $this->hasOne(Organizer::class, $endpoint);
    }

    public function venue()
    {
        $endpoint = 'venues/'. $this->venue_id;
        return $this->hasOne(Venue::class, $endpoint);
    }

    public function category()
    {
        $endpoint = 'categories/'. $this->category_id;
        return $this->hasOne(Category::class, $endpoint);
    }

    public function subcategory()
    {
        $endpoint = 'subcategories/'. $this->subcategory_id;
        return $this->hasOne(Subcategory::class, $endpoint);
    }

    public function format()
    {
        $endpoint = 'formats/'. $this->format_id;
        return $this->hasOne(Format::class, $endpoint);
    }

    public function logo()
    {
        $endpoint = 'media/'. $this->logo_id;
        return $this->hasOne(Media::class, $endpoint);
    }

    protected function setName($name)
    {
        $name = Markdown::convertToHtml($name);
        $name = strip_tags($name, 'p');
        $this->changed['name_html'] = $name;
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

    static public function expandedByDefault()
    {
        return [
            'logo',
            'venue',
            'organizer',
            'format',
            'category',
            'subcategory',
            'bookmark_info'
        ];
    }

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
