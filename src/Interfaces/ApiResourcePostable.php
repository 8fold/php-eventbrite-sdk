<?php

namespace Eightfold\Eventbrite\Interfaces;

interface ApiResourcePostable
{
    static public function parameterPrefix();
    static public function parametersToPost();
    static public function parametersToConvertToDotNotation();
}