<?php

namespace Eightfold\Eventbrite\Classes\Abstracts;

use Eightfold\Eventbrite\Eventbrite;

use Eightfold\Eventbrite\Traits\Gettable;
use Eightfold\Eventbrite\Traits\Settable;

abstract class ApiResource
{
    use Gettable,
        Settable;

    /**
     * Used for querying the Eventbrite api related to events.
     * @var null
     */
    public $eventbrite = null;

    /**
     * The raw payload provided at instantiation. 
     * 
     * @var null
     */
    protected $raw = null;

    /**
     * The updates made to the instance.
     *
     * If there is an update to that field stored here, this is the value that will
     * return. You can still explicitly request the raw value.
     * 
     * @var null
     */
    protected $changed = null;

    /**
     * GET the resource from the API using the passed Eventbrite instance
     * 
     * @param  string      $id         The Eventbrite ID for the resource 
     * @param  unknown     $eventbrite Usually an Eventbrite object to use when
     *                                 connecting; however, not type-hinted to allow
     *                                 overriding.
     * 
     * @return ApiResource             A new instance of the class
     */
    static public function find($eventbrite, string $id)
    {
        $class = static::classPath();
        $endpoint = static::baseEndpoint() .'/'. $id;

        // @todo: ClassLoader failing when not including class path explicitly
        return $eventbrite->get($endpoint, [], $class);
    }

    static public function getMany(Eventbrite $eventbrite, string $endpoint = null)
    {
        $class = static::classPath();
        if (is_null($endpoint)) {
            $endpoint = static::baseEndpoint();

        }

        // @todo: ClassLoader failing when not including class path explicitly
        return $eventbrite->get($endpoint, [], $class);
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
            $fieldPrefix = static::parameterPrefix();
            $postableFields = static::parametersToPost();
            $convertToDots = static::parametersToConvertToDotNotation();
            $updates = [];

            if (!is_null($this->changed) && count($this->changed) > 0) {
                foreach ($this->changed as $prop => $value) {
                    $isSettable = in_array($prop, $postableFields);
                    if ($isSettable) {
                        $prop = (in_array($prop, $convertToDots))
                            ? str_replace('_', '.', $prop)
                            : $prop;
                        $updates[$fieldPrefix .'.'. $prop] = $value;
                    }
                }
            } else {
                foreach ($this as $prop => $value) {
                    $isSettable = in_array($prop, $postableFields);
                    if ($isSettable) {
                        $prop = (in_array($prop, $convertToDots))
                            ? str_replace('_', '.', $prop)
                            : $prop;
                        $updates[$fieldPrefix .'.'. $prop] = $value;

                    }
                }                
            }
            $endpoint = $this->endpoint();
            $class = static::classPath();
            $updated = $this->eventbrite->post($endpoint, $updates, $class);
            $this->raw = $updated->raw;
            $this->changed = null;
            unset($updated);
            
        } else {
            throw new \Exception('This is not a valid Eventbrite resource.');

        }
    }    
}