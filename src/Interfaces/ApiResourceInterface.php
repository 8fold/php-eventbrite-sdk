<?php

namespace Eightfold\Eventbrite\Interfaces;

interface ApiResourceInterface
{
    static public function expandedByDefault();
    static public function classPath();
    public function endpoint();
}