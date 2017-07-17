<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\Core\ApiResource;

use Eightfold\Eventbrite\Classes\SubObjects\DisplaySetting;
use Eightfold\Eventbrite\Classes\SubObjects\TicketClassCollection;
use Eightfold\Eventbrite\Classes\SubObjects\QuestionCollection;
use Eightfold\Eventbrite\Classes\SubObjects\AttendeeCollection;
use Eightfold\Eventbrite\Classes\SubObjects\OrderCollection;
use Eightfold\Eventbrite\Classes\SubObjects\DiscountCollection;
use Eightfold\Eventbrite\Classes\SubObjects\AccessCodeCollection;
use Eightfold\Eventbrite\Classes\SubObjects\TransferCollection;
use Eightfold\Eventbrite\Classes\SubObjects\TeamCollection;

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
     * POST /events/ - Makes a new event, and returns an event for the specified
     *                 event. Does not support the creation of repeating event series.
     *
     * @return [type] [description]
     *
     * @todo Implement functionality for creating a new event.
     */
    static public function withOptions()
    {

    }

    public function __construct($client, $idOrPayload)
    {
        $this->client = $client;

        if (is_string($idOrPayload)) {
            $this->id = $id;

        } else {
            $this->id = $idOrPayload['id'];
            parent::__construct($client, $idOrPayload);

        }
        $this->endpoint = 'events/'. $this->id;
    }

    /**
     * POST /events/:id/ - Updates an event. Returns an event for the specified event.
     *                     Does not support updating a repeating event series parent (
     *                     see POST /series/:id/).
     *
     * @return [type] [description]
     *
     * @todo Implement this functionality.
     *
     */
    public function update()
    {

    }

    /**
     * POST /events/:id/publish/ - Publishes an event if it has not already been
     *                             deleted. In order for publish to be permitted, the
     *                             event must have all necessary information,
     *                             including a name and description, an organizer, at
     *                             least one ticket, and valid payment options. This
     *                             API endpoint will return argument errors for event
     *                             fields that fail to validate the publish
     *                             requirements. Returns a boolean indicating success
     *                             or failure of the publish.
     *
     * @return [type] [description]
     */
    public function publish()
    {

    }

    /**
     * POST /events/:id/unpublish/ - Unpublishes an event. In order for a free event
     *                               to be unpublished, it must not have any pending
     *                               or completed orders, even if the event is in the
     *                               past. In order for a paid event to be
     *                               unpublished, it must not have any pending or
     *                               completed orders, unless the event has been
     *                               completed and paid out. Returns a boolean
     *                               indicating success or failure of the unpublish.
     *
     * @return [type] [description]
     */
    public function unpublish()
    {

    }

    /**
     * POST /events/:id/cancel/ - Cancels an event if it has not already been deleted.
     *                            In order for cancel to be permitted, there must be
     *                            no pending or completed orders. Returns a boolean
     *                            indicating success or failure of the cancel.
     *
     * @return [type] [description]
     */
    public function cancel()
    {

    }

    /**
     * DELETE /events/:id/ - Deletes an event if the delete is permitted. In order for
     *                       a delete to be permitted, there must be no pending or
     *                       completed orders. Returns a boolean indicating success or
     *                       failure of the delete.
     *
     * @return [type] [description]
     */
    public function delete()
    {

    }

    /**
     * GET /events/:id/display_settings/ - Retrieves the display settings for an event.
     *
     * @return \Eightfold\Eventbrite\Classes\SubObjects\DisplaySetting
     *
     * @todo Re-implement
     */
    public function display_settings()
    {
        return $this->property($this->id, 'display_settings', DisplaySetting::class);
    }

    /**
     * GET /events/:id/ticket_classes/ - Returns a paginated response with a key of
     *                                   ticket_classes, containing a list of
     *                                   ticket_class.
     *
     * @param  string $id [description]
     * @return [type]     [description]
     */
    public function ticket_classes($id = '')
    {
        return $this->property($this->id . $id, 'ticket_classes', TicketClassCollection::class);
    }

    /**
     * GET /events/:id/ticket_classes/:ticket_class_id/ - Gets and returns a single
     *                                                    ticket_class by ID, as the
     *                                                    key ticket_class.
     *
     * @param  string $id [description]
     * @return [type]     [description]
     *
     * @todo Not working - not sure why. Unit test does not do anything strange to
     *       get the id it uses to pass.
     */
    public function ticket_class($id = '')
    {
        $ticket_classes = $this->ticket_classes();
        foreach ($ticket_classes as $ticket_class) {
            if ($ticket_class->id == $id) {
                return $ticket_class;

            }
        }
        return null;
    }

    // TODO: Revisit - might need to be its own class

    /**
     * GET /events/:id/canned_questions/ - This endpoint returns canned questions of a
     *                                     single event (examples: first name, last
     *                                     name, company, prefix, etc.). This endpoint
     *                                     will return question.
     *
     * @return [type] [description]
     */
    public function canned_questions()
    {
        return $this->property($this->id, 'canned_questions', QuestionCollection::class);
    }

    /**
     * GET /events/:id/questions/ - Eventbrite allows event organizers to add custom
     *                              questions that attendees fill out upon
     *                              registration. This endpoint can be helpful for
     *                              determining what custom information is collected
     *                              and available per event. This endpoint will return
     *                              question.
     *
     * @param  string $id [description]
     * @return [type]     [description]
     *
     * @todo Test returns 0 questions, need to test this and the single quession return
     */
    public function questions($id = '')
    {
        return $this->property($this->id . serialize($id), 'questions', QuestionCollection::class);
    }

    /**
     * GET /events/:id/questions/:id/ - This endpoint will return question for a
     *                                  specific question id.
     *
     * @param  [type] $id [description]
     * @return [type]     [description]
     *
     * @todo Implement this functionality and test.
     */
    public function question($id)
    {

    }

    /**
     * GET /events/:id/attendees/ - Returns a paginated response with a key of
     *                              attendees, containing a list of attendee.
     *
     * @param  string $id [description]
     * @return [type]     [description]
     */
    public function attendees($id = '')
    {
        return $this->property($this->id . serialize($id), 'attendees', AttendeeCollection::class);
    }

    /**
     * GET /events/:id/attendees/:attendee_id/ - Returns a single attendee by ID, as
     *                                           the key attendee.
     *
     * @param  string $id [description]
     * @return [type]     [description]
     *
     * @todo Implement and test
     */
    public function attendee($id = '')
    {

    }

    /**
     * GET /events/:id/orders/ - Returns a paginated response with a key of orders,
     *                           containing a list of order against this event.
     *
     * @return [type] [description]
     */
    public function orders($options = [])
    {
        return $this->property($this->id . serialize($options), 'orders', OrderCollection::class);
    }

    /**
     * GET /events/:id/discounts/ - Returns a paginated response with a key of
     *                              discounts, containing a list of discounts
     *                              available on this
     *
     * @param  string $id [description]
     * @return [type]     [description]
     *
     * @todo Improve test - test event does not have any discounts.
     */
    public function discounts($id = '')
    {
        return $this->property($this->id . $id, 'discounts', DiscountCollection::class);
    }

    /**
     * GET /events/:id/discounts/:discount_id/ - Gets a discount by ID as the key
     *                                           discount.
     *
     * @param  string $id [description]
     * @return [type]     [description]
     *
     * @todo Implement and test
     */
    public function discount($id = '')
    {

    }

    /**
     * GET /events/:id/public_discounts/ - Returns a paginated response with a key of
     *                                     discounts, containing a list of public
     *                                     discounts available on this event. Note
     *                                     that public discounts and discounts have
     *                                     exactly the same form and structure;
     *                                     they’re just namespaced separately, and
     *                                     public ones (and the public GET endpoints)
     *                                     are visible to anyone who can see the event.
     *
     * @param  string $id [description]
     * @return [type]     [description]
     *
     * @todo Test event does not have any public discounts.
     */
    public function public_discounts($id = '')
    {
        return $this->property($this->id . $id, 'public_discounts', DiscountCollection::class);
    }

    /**
     * GET /events/:id/public_discounts/:discount_id/ - Gets a public discount by ID
     *                                                  as the key discount.
     *
     * @param  string $id [description]
     * @return [type]     [description]
     */
    public function public_discount($id = '')
    {

    }

    /**
     * GET /events/:id/access_codes/ - Returns a paginated response with a key of
     *                                 access_codes, containing a list of access_codes
     *                                 available on this event.
     *
     * @param  string $id [description]
     * @return [type]     [description]
     *
     * @todo Test better, current event has none.
     */
    public function access_codes($id = '')
    {
        return $this->property($this->id . $id, 'access_codes', AccessCodeCollection::class);
    }

    /**
     * GET /events/:id/access_codes/:access_code_id/ - Gets a access_code by ID as the
     *                                                 key access_code.
     *
     * @param  string $id [description]
     * @return [type]     [description]
     *
     * @todo Implement and test, current event has none.
     */
    public function access_code($id = '')
    {

    }

    /**
     * GET /events/:id/transfers/ - Returns a list of transfers for the event.
     *
     * @return [type] [description]
     */
    public function transfers($options = [])
    {
        return $this->property($this->id . serialize($options), 'transfers', TransferCollection::class, $options);
    }

    /**
     * GET /events/:id/teams/ - Returns a list of attendee-team for the event.
     *
     * @param  string $id [description]
     * @return [type]     [description]
     */
    public function teams($id = '')
    {
        return $this->property($this->id . $id, 'teams', TeamCollection::class);
    }

    /**
     * GET /events/:id/teams/:id/ - Returns information for a single attendee-team.
     *
     * @param  string $id [description]
     * @return [type]     [description]
     *
     * @todo Test and implement
     */
    public function team($id = '')
    {

    }

    /***********************/
    /* End basic endpoints */
    /***********************/
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
