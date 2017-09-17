<?php

namespace Eightfold\Eventbrite\Classes\SubObjects;

use Eightfold\Eventbrite\Classes\Core\ApiCollection;

use Eightfold\Eventbrite\Classes\SubObjects\AccessCode;

/**
 * @package Collections
 */
class AccessCodeCollection extends ApiCollection
{
    public function __construct(array $payload, $client)
    {
        $class = AccessCode::class;
        $keyToInstantiate = 'access_codes';
        $keysToConvertToLocalVars = ['pagination'];
        parent::__construct($payload, $client, $class, $keyToInstantiate, $keysToConvertToLocalVars);
    }
}
