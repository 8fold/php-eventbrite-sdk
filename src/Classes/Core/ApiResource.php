<?php

namespace Eightfold\Eventbrite\Classes\Core;

use Eightfold\Eventbrite\Eventbrite;

use Eightfold\Eventbrite\Classes\Core\ApiCallBuilder;

use Eightfold\Eventbrite\Traits\Gettable;
use Eightfold\Eventbrite\Traits\Settable;

abstract class ApiResource
{
    use Gettable,
        Settable;

    /**
     * Used for querying the api.
     * @var null
     */
    private $client = null;

    /**
     * The raw payload provided at instantiation.
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
     * Keep the raw payload from Eventbrite as a private variable.
     * 
     * @param array      $payload    The decoded payload from Eventbrite
     * @param Eventbrite $eventbrite The ApiClient and creds to associate with instance
     */
    public function __construct(array $payload, $client)
    {
        $this->client = $client;
        $setup = (isset($payload['body']))
            ? $payload['body']
            : $payload;
        $this->raw = $setup;
    }

    protected function hasOne($class, $endpoint, $options = [], $keyToInstantiate = null, $keysToConvertToCollectionVars = [])
    {
        $baseCaller = debug_backtrace()[1]['function'];
        $caller = '_'. $baseCaller;
        if (isset($this->{$caller}) && !is_null($this->{$caller})) {
            return $this->{$caller};
            
        }

        $payload = [];
        if (isset($this->raw[$baseCaller]) && !is_null($this->raw[$baseCaller])) {
            $payload = $this->raw[$baseCaller];

        }

        $this->{$caller} = new ApiCallBuilder(
            $this->client, 
            $class, 
            $endpoint, 
            static::getOptions($class, $options));
        return $this->{$caller};
    }

    protected function hasMany($class, $endpoint, $options = [], $keyToInstantiate = null, $keysToConvertToCollectionVars = [])
    {
        $baseCaller = debug_backtrace()[1]['function'];
        $caller = '_'. $baseCaller;
        if (isset($this->{$caller}) && !is_null($this->{$caller})) {
            return $this->{$caller};
            
        }

        $payload = [];
        if (isset($this->raw[$baseCaller]) && !is_null($this->raw[$baseCaller])) {
            $payload = $this->raw[$baseCaller];

        }

        $this->{$caller} = new ApiCallBuilder(
            $this->client, 
            $class, 
            $endpoint, 
            static::getOptions($class, $options));
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
            $updated = $this->client->post($endpoint, $updates, $class);
            $this->raw = $updated->raw;
            $this->changed = null;
            unset($updated);
            
        } else {
            throw new \Exception('This is not a valid Eventbrite resource.');

        }
    }    
}