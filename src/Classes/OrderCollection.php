<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\Core\ApiCollection;

use Eightfold\Eventbrite\Classes\Order;

/**
 * @package Collections
 */
class OrderCollection extends ApiCollection
{
    public function __construct(array $payload, $client)
    {
        $class = Order::class;
        $keyToInstantiate = 'orders';
        $keysToConvertToLocalVars = ['pagination'];
        parent::__construct($payload, $client, $class, $keyToInstantiate, $keysToConvertToLocalVars);
    }
}
