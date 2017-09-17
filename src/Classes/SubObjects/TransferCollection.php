<?php

namespace Eightfold\Eventbrite\Classes\SubObjects;

use Eightfold\Eventbrite\Classes\Core\ApiCollection;

use Eightfold\Eventbrite\Classes\SubObjects\Transfer;

/**
 * @package Collections
 */
class TransferCollection extends ApiCollection
{
    public function __construct(array $payload, $client)
    {
        $class = Transfer::class;
        $keyToInstantiate = 'transfers';
        $keysToConvertToLocalVars = ['pagination'];
        parent::__construct($payload, $client, $class, $keyToInstantiate, $keysToConvertToLocalVars);
    }
}
