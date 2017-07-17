<?php

namespace Eightfold\Eventbrite\Classes\SubObjects;

use Eightfold\Eventbrite\Classes\Core\ApiCollection;

use Eightfold\Eventbrite\Classes\SubObjects\Question;

/**
 * @package Collections
 */
class QuestionCollection extends ApiCollection
{
    /**
     * [__construct description]
     *
     * @param [type] $client  [description]
     * @param [type] $payload [description]
     */
    public function __construct($client, $endpoint)
    {
        parent::__construct($client, $endpoint, 'questions', Question::class);
    }
}
