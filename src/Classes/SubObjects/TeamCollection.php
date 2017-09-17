<?php

namespace Eightfold\Eventbrite\Classes\SubObjects;

use Eightfold\Eventbrite\Classes\Core\ApiCollection;

use Eightfold\Eventbrite\Classes\SubObjects\Team;

/**
 * @package Collections
 */
class TeamCollection extends ApiCollection
{
    public function __construct(array $payload, $client)
    {
        $class = Team::class;
        $keyToInstantiate = 'teams';
        $keysToConvertToLocalVars = ['pagination'];
        parent::__construct($payload, $client, $class, $keyToInstantiate, $keysToConvertToLocalVars);
    }
}
