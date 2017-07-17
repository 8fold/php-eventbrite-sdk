<?php

namespace Eightfold\Eventbrite\Classes\SubObjects;

use Eightfold\Eventbrite\Classes\Core\ApiCollection;

use Eightfold\Eventbrite\Classes\SubObjects\Transfer;

/**
 * @package Collections
 */
class TransferCollection extends ApiCollection
{
    /**
     * [__construct description]
     *
     * @param [type] $client  [description]
     * @param [type] $payload [description]
     */
    public function __construct($client, $endpoint)
    {
        parent::__construct($client, $endpoint, 'transfers', Transfer::class);
    }

    // public function __construct(array $payload, $client)
    // {
    //     $class = Transfer::class;
    //     $keyToInstantiate = 'transfers';
    //     $keysToConvertToLocalVars = ['pagination'];
    //     parent::__construct($payload, $client, $class, $keyToInstantiate, $keysToConvertToLocalVars);
    // }
}
