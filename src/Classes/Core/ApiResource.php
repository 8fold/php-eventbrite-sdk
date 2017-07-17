<?php

namespace Eightfold\Eventbrite\Classes\Core;

use Eightfold\Eventbrite\Eventbrite;

use Eightfold\Eventbrite\Classes\Core\ApiCallBuilder;

use Eightfold\Eventbrite\Traits\Gettable;
use Eightfold\Eventbrite\Traits\Settable;

/**
 * A single object returned from the API.
 *
 * @category Core
 *
 * @todo Consider making a factory for this in core.
 */
abstract class ApiResource
{
    use Gettable,
        Settable;

    protected $client = null;

    protected $id = '';

    protected $endpoint = '';

    protected $me = null;

    protected $raw = null;

    protected $changed = null;

    static public function find($client, $class, $endpoint, array $options = [], $keyToInstantiate = null, $keysToConvertToCollectionVars = [])
    {
        $opt = static::getOptions($class, $options);
        $new = new ApiCallBuilder($client, $class, $endpoint, $opt, $keyToInstantiate, $keysToConvertToCollectionVars);
        return $new;
    }

    static private function getOptions($class, $options = [], $expansions = [])
    {
        $methodExists = method_exists($class, 'expandedByDefault');
        if ($methodExists && count($class::expandedByDefault()) > 0) {
            $expansions = ['expand' => implode(',', $class::expandedByDefault())];
        }
        $opt = array_merge($options, $expansions);
        return $opt;
    }

    /**
     * Instantiate resource sub-class using given payload and client.
     *
     * @param array      $payload    The decoded payload from Eventbrite
     * @param Eventbrite $client     The ApiClient and creds to associate with instance
     */
    public function __construct($client, $payload)
    {
        $this->client = $client;
        $setup = (isset($payload->body))
            ? $payload->body
            : $payload;
        $this->raw = $setup;
    }

    private function getMe($payload)
    {
        // $this->client = $client;
        $setup = (isset($payload->body))
            ? $payload->body
            : $payload;
        $this->raw = $setup;
    }

    public function get()
    {
        if (is_null($this->me)) {
            $payload = $this->client->get($this->endpoint);
            // Make sure we have instantiated ourselves with a payload.
            static::__construct($this->client, $payload);
            $this->me = $this;
        }
        return $this->me;
    }

    /**
     * Returns instance of class, usually an ApiResource or ApiCollection.
     *
     * @param  string $serialize    A string to has as a prefix for caching the
     *                              `$propertyName` value.
     * @param  string $propertyName The property name to cache the object in.
     * @param  string $class        The full class name to instantiate.
     *
     * @return [type]               [description]
     */
    protected function property($serialize, $propertyName, $class, $options = [])
    {
        // We create a hash to allow caching of resources with options.
        $serialized = md5($serialize);

        // Hashed value not set in property.
        if (!isset($this->{$propertyName}[$serialized])) {
            // The compiled endpoint to use with the ApiResource or ApiCollection
            // instance.
            $endpoint = $this->endpoint .'/'. $propertyName;

            // Instantiate and set the object with the property.
            $this->{$propertyName}[$serialized] = new $class($this->client, $endpoint, $options);

        }

        // Return the cached or newly minted value.
        return $this->{$propertyName}[$serialized];
    }

    protected function hasOne($class, $endpoint, $options = [])
    {
        // We are preparing to generate the local instance variable.
        // Get the function name that called this method.
        // Prefix the function name with and underscore.
        $baseCaller = debug_backtrace()[1]['function'];
        $caller = '_'. $baseCaller;

        // Check to see if the instance already has the property and
        // that it is not null.
        if (!isset($this->{$caller}) || is_null($this->{$caller})) {
            // Instantiate a new API caller.
            $this->{$caller} = new ApiCallBuilder(
                $this->client,
                $class,
                $endpoint,
                static::getOptions($class, $options));

        }
        return $this->{$caller};
    }

    protected function hasMany($class, $endpoint, $options = [])
    {
        // We are preparing to generate the local instance variable.
        // Get the function name that called this method.
        // Prefix the function name with and underscore.
        $baseCaller = debug_backtrace()[1]['function'];
        $caller = '_'. $baseCaller;

        // Check to see if the instance already has the property and
        // that it is not null.
        if (!isset($this->{$caller}) || is_null($this->{$caller})) {
            // Instantiate a new API caller.
            $this->{$caller} = new ApiCallBuilder(
                $this->client,
                $class,
                $endpoint,
                static::getOptions($class, $options));

        }
        return $this->{$caller};
    }

    public function resetChanges()
    {
        $this->changed = null;
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
     * @deprecated 1.0.0 This is a depracation description.
     *
     * With a new paragraph.
     *
     * @see  \Eightfold\Eventbrite\Core\ApiClient Some description.
     *
     * With a new paragraph.
     *
     * @throws \Exception Description of the throw.
     *
     * @return null Doesn't return anything.
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
            $updated = $this->client->post($endpoint, $updates, $class);
            $this->raw = $updated->raw;
            $this->changed = null;
            unset($updated);

        } else {
            throw new \Exception('This is not a valid Eventbrite resource.');

        }
    }
}
