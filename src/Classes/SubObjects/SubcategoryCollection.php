<?php

namespace Eightfold\Eventbrite\Classes\SubObjects;

use Eightfold\Eventbrite\Classes\Core\ApiCollection;

use Eightfold\Eventbrite\Classes\SubObjects\Subcategory;

class SubcategoryCollection extends ApiCollection
{
    public function __construct(array $payload, $client) 
    {
        $class = Subcategory::class;
        $keyToInstantiate = 'subcategories';
        $keysToConvertToLocalVars = ['pagination'];
        parent::__construct($payload, $client, $class, $keyToInstantiate, $keysToConvertToLocalVars);
    }
}