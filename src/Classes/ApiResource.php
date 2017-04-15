<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Traits\Gettable;

class ApiResource
{
    use Gettable;

    /**
     * Used for querying the Eventbrite api related to events.
     * @var null
     */
    protected $eventbrite = null;

    /**
     * The raw payload provided at instantiation. 
     * @var null
     */
    private $raw = null;

    static public function find($categoryId, $eventbrite)
    {
        $class = static::classPath;
        return new $class($eventbrite->get(static::endpointEntry . $categoryId), $eventbrite);
    }

    public function __construct($payload, $eventbrite)
    {
        $this->eventbrite = $eventbrite;
        $setup = (isset($payload['body']))
            ? $payload['body']
            : $payload;
        $this->raw = $setup;
    }

    protected function get(string $objectPath, string $pathOrProp, string $path = null)
    {
        $property = $pathOrProp;
        if (is_null($path)) {
            // set default internal property name based on class name
            // using the the part from the full class path.
            $objParts = explode('\\', $objectPath);
            $classSingle = end($objParts);
            $property = strtolower($classSingle);

            // make sure using second argument for call.
            $path = $pathOrProp;
        }

        if (!isset($this->{$property}) || is_null($this->{$property})) {
            $resource = $this->eventbrite->get($path);
            $this->{$property} = new $objectPath($resource, $this->eventbrite);

        }        
        return $this->{$property};
    }
}