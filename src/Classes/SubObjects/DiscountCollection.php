<?php

namespace Eightfold\Eventbrite\Classes\SubObjects;

use Eightfold\Eventbrite\Classes\Core\ApiCollection;

use Eightfold\Eventbrite\Classes\SubObjects\Discount;

/**
 * @package DiscountCollection alias
 */
class DiscountCollection extends ApiCollection
{
    /**
     * [__construct description]
     *
     * @param [type] $client  [description]
     * @param [type] $payload [description]
     */
    public function __construct($client, $endpoint)
    {
        parent::__construct($client, $endpoint, 'discounts', Discount::class);
    }
    // public function __construct(array $payload, $client)
    // {
    //     $class = Discount::class;
    //     $keyToInstantiate = 'discounts';
    //     $keysToConvertToLocalVars = ['pagination'];
    //     parent::__construct($payload, $client, $class, $keyToInstantiate, $keysToConvertToLocalVars);
    // }
}
