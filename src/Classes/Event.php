<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\ApiResource;

use Eightfold\Eventbrite\Classes\Eventbrite;
use Eightfold\Eventbrite\Classes\Organizer;
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
     * The organizer associated with the event.
     * @var null
     */
    private $organizer = null;

    /**
     * The venue for the event.
     * @var null
     */
    private $venue = null;

    /**
     * The main category of the event.
     * @var null
     */
    private $category = null;

    /**
     * The subcategory for the event.
     * @var null
     */
    private $subcategory = null;

    /**
     * The different types of tickets someone can buy.
     * @var null
     */
    private $ticketClasses = null;

    /**
     * The lowest cost for the event.
     * @var null
     */
    private $lowCost = null;

    /**
     * The TicketClass with the lowest cost.
     * @var null
     */
    private $lowestType = null;

    /**
     * The highest cost for the event.
     * @var null
     */
    private $highCost = null;

    /**
     * The TicketClass with the highest cost.
     * @var null
     */
    private $highestType = null;

    /**
     * The questions that must be answered for the event.
     * @var null
     */
    private $questions = null;

    /**
     * [__construct description]
     * @param array      $payload    [description]
     * @param Eventbrite $eventbrite [description]
     * @param array      $getRelated [description]
     */
    public function __construct(array $payload, Eventbrite $eventbrite)
    {
        parent::__construct($payload, $eventbrite);
        if ($getOrganizer) {
            $organizer = $eventbrite->get('organizers/'. $payload['organizer_id']);
            $this->organizer = new Organizer($organizer, $eventbrite);

        }

        if ($getVenue) {
            $venue = $eventbrite->get('venues/'. $payload['venue_id']);
            $this->venue = new Venue($venue);

        }

        if ($getCategories) {
            $category = $eventbrite->get('categories/'. $payload['category_id']);
            $this->category = new Category($category);

            $subcategory = $eventbrite->get('subcategories/'. $payload['subcategory_id']);
            $this->subcategory = new Category($subcategory);

        }

        if ($getTicketClasses) {
            $ticketClasses = $eventbrite->get('events/'. $payload['id'] .'/ticket_classes');
            $ticketClasses = $ticketClasses['body']['ticket_classes'];
            $this->highCost = 0;
            $this->lowCost = $this->highCost;
            foreach ($ticketClasses as $ticketClass) {
                $tc = new TicketClass($ticketClass);
                
                if ($tc->cost > $this->highCost) {
                    $this->highCost = $tc->cost;
                    $this->highestType = $tc;
                }

                if ($tc->cost < $this->lowCost) {
                    $this->lowCost = $tc->cost;
                    $this->lowestType = $tc;
                }

                $this->ticketClasses[] = $tc;

            }
        }

        if ($getQuestions) {
            $questions = $eventbrite->get('events/'. $payload['id'] .'/questions');
            dd($questions);
        }
    }

    public function organizer()
    {
        return $this->organizer;
    }

    public function venue()
    {
        return $this->venue;
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

    public function category()
    {
        return $this->category;
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