<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\Core\ApiCollection;

use Eightfold\Eventbrite\Classes\Category;

/**
 * @package Collections
 */
class CategoryCollection extends ApiCollection
{
    /**
     * Hell
     * @param array  $payload Tabbing works
     * @param ApiClient $client  Client to use when making calls.
     */
    public function __construct(array $payload, $client)
    {
        $class = Category::class;
        $keyToInstantiate = 'categories';
        $keysToConvertToLocalVars = ['pagination'];
        parent::__construct($payload, $client, $class, $keyToInstantiate, $keysToConvertToLocalVars);

    }
}
