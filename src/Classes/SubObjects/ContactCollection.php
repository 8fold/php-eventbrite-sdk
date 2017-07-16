<?php

namespace Eightfold\Eventbrite\Classes\SubObjects;

use Eightfold\Eventbrite\Classes\Core\ApiCollection;

use Eightfold\Eventbrite\Classes\SubObject\Contact;

/**
 * @package Collections
 */
class ContactCollection extends ApiCollection
{
    public function __construct($client, $endpoint)
    {
        parent::__construct($client, $endpoint, 'contacts', Contact::class);
    }
}
