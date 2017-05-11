<?php

namespace Eightfold\Eventbrite\Classes\SubObjects;

use Eightfold\Eventbrite\Classes\Core\ApiCollection;

use Eightfold\Eventbrite\Classes\SubObjects\Question;

/**
 * @package Collections
 */
class QuestionCollection extends ApiCollection
{
    public function __construct(array $payload, $client)
    {
        $class = Question::class;
        $keyToInstantiate = 'questions';
        $keysToConvertToLocalVars = ['pagination'];
        parent::__construct($payload, $client, $class, $keyToInstantiate, $keysToConvertToLocalVars);
    }
}
