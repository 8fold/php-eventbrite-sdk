<?php

namespace Eightfold\Eventbrite\Classes\Abstracts;

use Eightfold\Eventbrite\Eventbrite;

use Eightfold\Eventbrite\Classes\Abstracts\ApiCallBuilder;

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
    public $client = null;

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

    /**
     * GET a single record from Eventbrite
     *
     * @param  $apiClientOrApiResource We need a client. Either pass in a client or
     *                                 an ApiResource subclass, as it will have a
     *                                 client available to us.
     * @param  string $id              The object id to append to the based endpoint.
     * @param  array  $options         Used for building parameters on the endpoint.
     *                                            
     * @return ApiResource subclass
     */
    static public function find($apiClientOrApiResource, string $id, $options = [])
    {
        $client = self::getClient($apiClientOrApiResource);
        $class = static::classPath();
        $endpoint = static::baseEndpoint() .'/'. $id;
        return $client->get($endpoint, self::getOptions($options), $class);
    }

    /**
     * GET multiple records of the same type from Eventbrite
     *
     * @see `find()` - With `id` being replaced with `endpoint`.
     *
     * @param  string $endpoint The endpoint to call. As we do not have a targeted
     *                          object.
     *                                            
     * @return Collection of ApiResource subclasses
     */
    static public function getMany($apiClientOrApiResource, string $class, string $endpoint = null, $options = [])
    {
        $client = self::getClient($apiClientOrApiResource);
        $class = static::classPath();
        if (is_null($endpoint)) {
            $endpoint = static::baseEndpoint();
        }
        $options = self::getOptions($options);
        // print_r($options);
        return $client->get($endpoint, $options, $class);
    }

    /**
     * Get client to use with calls
     *
     * The `object` should either be an ApiClient, a subclass of ApiClient, an
     * ApiResource, or a subclass of ApiResource. Then we either return the original
     * or the client of the original object, respectively.
     * 
     * @param  $apiClientOrApiResource See above.
     * 
     * @return ApiClient               Whether ApiClient or ApiResource, retrun 
     *                                 ApiClient.
     */
    static private function getClient($apiClientOrApiResource)
    {
        if (is_a($apiClientOrApiResource, ApiClient::class)) {
            return $apiClientOrApiResource;
        }
        print('needed to get client of instance');
        return $apiClientOrApiResource->client;
    }

    // static private function getOptions(array $options = [])
    // {
    //     $expand = null;

    //     // alwyas use the default expansion - unless others are passed in.
    //     if (isset($options['expand']) && is_array($options['expand'])) {
    //         $expand = self::getExpansions($options['expand']);
    //         unset($options['expand']);

    //     }
    //     return array_merge($options, self::getExpansions());
    // }

    // static private function getExpansions($expansions = [])
    // {
    //     if (count($expansions) > 0 ) {
    //         return ['expand' => implode(',', $expansions)];

    //     } elseif (count(static::expandedByDefault()) > 0) {
    //         return ['expand' => implode(',', static::expandedByDefault())];

    //     }
    //     return $expansions;
    // }   

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

    protected function hasOne(string $class, string $endpoint, array $options = [])
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

        $this->{$caller} = new ApiCallBuilder($this->client, $class, $endpoint, $this->getOptions($class, $options), $payload);
        return $this->{$caller};
    }

    protected function hasMany(string $class, string $endpoint, array $options = [])
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

        $this->{$caller} = new ApiCallBuilder($this->client, $class, $endpoint, $this->getOptions($class, $options), $payload);
        return $this->{$caller};
    }

    private function getOptions($class, $options = [], $expansions = [])
    {
        if (count($class::expandedByDefault())) {
            $expansions = ['expand' => implode(',', $class::expandedByDefault())];    
        }
        $opt = array_merge($options, $expansions);
        return $opt;
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