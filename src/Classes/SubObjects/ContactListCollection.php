<?php

namespace Eightfold\Eventbrite\Classes\SubObjects;

use Eightfold\Eventbrite\Classes\Core\ApiCollection;

use Eightfold\Eventbrite\Classes\SubObject\ContactList;

/**
 * @package Collections
 */
class ContactListCollection extends ApiCollection
{
    public function __construct($client, $endpoint)
    {
        parent::__construct($client, $endpoint, 'contact_lists', ContactList::class);
    }
}
