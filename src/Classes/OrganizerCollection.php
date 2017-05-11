<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\Core\ApiCollection;

use Eightfold\Eventbrite\Classes\Organizer;

/**
 * @package Collections
 */
class OrganizerCollection extends ApiCollection
{
    public function __construct(array $payload, $client)
    {
        $class = Organizer::class;
        $keyToInstantiate = 'organizers';
        $keysToConvertToLocalVars = ['pagination'];
        parent::__construct($payload, $client, $class, $keyToInstantiate, $keysToConvertToLocalVars);
    }
}
