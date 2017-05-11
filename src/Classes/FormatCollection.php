<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\Core\ApiCollection;

use Eightfold\Eventbrite\Classes\Format;

/**
 * @package Collections
 */
class FormatCollection extends ApiCollection
{
    public function __construct(array $payload, $client)
    {
        $class = Format::class;
        $keyToInstantiate = 'formats';
        $keysToConvertToLocalVars = ['pagination'];
        parent::__construct($payload, $client, $class, $keyToInstantiate, $keysToConvertToLocalVars);
    }
}
