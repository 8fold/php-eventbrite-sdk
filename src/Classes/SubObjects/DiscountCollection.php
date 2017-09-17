<?php

namespace Eightfold\Eventbrite\Classes\SubObjects;

use Eightfold\Eventbrite\Classes\Core\ApiCollection;

use Eightfold\Eventbrite\Classes\SubObjects\Discount;

/**
 * @package DiscountCollection alias
 */
class DiscountCollection extends ApiCollection
{
    public function __construct(array $payload, $client)
    {
        $class = Discount::class;
        $keyToInstantiate = 'discounts';
        $keysToConvertToLocalVars = ['pagination'];
        parent::__construct($payload, $client, $class, $keyToInstantiate, $keysToConvertToLocalVars);
    }
}
