<?php

namespace Eightfold\Eventbrite\Classes\SubObjects;

use Eightfold\Eventbrite\Classes\SubObjects\EventSub;

/**
 * @package EventSub alias
 */
class DisplaySetting extends EventSub
{
    public function __construct($client, $endpoint)
    {
        $this->client = $client;
        $this->endpoint = $endpoint;
    }

    /**
     * POST /events/:id/display_settings/ - Updates the display settings for an event.
     *
     * @return [type] [description]
     *
     * @todo Implement this functionality
     *
     */
    public function update()
    {

    }
}
