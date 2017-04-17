<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Eventbrite;
use Eightfold\Eventbrite\Traits\Gettable;

abstract class ApiResource
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

    /**
     * GET the resource from the API using the passed Eventbrite instance
     * 
     * @param  string      $id         The Eventbrite ID for the resource 
     * @param  Eventbrite  $eventbrite The ApiClient and creds to use
     * 
     * @return ApiResource             A new instance of the class
     */
    static public function find(string $id, Eventbrite $eventbrite)
    {
        $class = static::classPath;
        $resourse = $eventbrite->get(static::endpointEntry . $id);
        return new $class($eventbrite->get(static::endpointEntry . $categoryId), $eventbrite);
    }

    /**
     * Keep the raw payload from Eventbrite as a private variable.
     * 
     * @param array      $payload    The decoded payload from Eventbrite
     * @param Eventbrite $eventbrite The ApiClient and creds to associate with instance
     */
    public function __construct(array $payload, Eventbrite $eventbrite)
    {
        $this->eventbrite = $eventbrite;
        $setup = (isset($payload['body']))
            ? $payload['body']
            : $payload;
        $this->raw = $setup;
    }

    /**
     * Save changes made to the resource.
     *
     * Loops over all publicly accessible properties to build the update. Each class
     * (Event, Category, and so on) should have a settableFields constant, which will
     * be used to determine if the property should be considered in the update.
     * 
     * Further, each class should have a `postKey` constant, which tells ApiResource
     * what the prefix for the field name is. 
     * 
     * Finally, each class should have an `endpointEntry` constant, which tells
     * ApiResource what the base endpoint is (`events/`, for example).
     *
     * Optionally, each class can have a `convertToDots` constant, which tells
     * ApiResource which fields should be converted from underscores to periods. For 
     * example, the events entry point has the key `event.name.html`. This is not a
     * traditional key name for PHP; instead, `name_html` is accepted by ApiResource.
     * `name_html` is listed in the `convertToDots` constant of the Event class.
     * Therefore, when saved, it will be converted from `name_html` to `name.html`,
     * and then prepended with the `postKey`, making it `event.name.html`.
     * 
     * @return [type] [description]
     */
    public function save()
    {
        if (isset($this->raw['id'])) {
            $updates = [];
            foreach ($this as $prop => $value) {
                $isSettable = in_array($prop, static::settableFields);
                if ($isSettable) {
                    $prop = (in_array($prop, static::convertToDots))
                        ? str_replace('_', '.', $prop)
                        : $prop;
                    $updates[static::postKey .'.'. $prop] = $value;

                }
            }
            $ep = static::endpointEntry . $this->raw['id'];
            $class = Event::class;
            $updated = $this->eventbrite->post($ep, $class, $updates);
            $this->raw = $updated->raw;
            unset($updated);
            
        } else {
            throw new \Exception('This is not a valid Eventbrite resource.');

        }
    }    
}