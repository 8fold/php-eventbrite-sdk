<?php

namespace Eightfold\Eventbrite\Classes\Core;

use Eightfold\Eventbrite\Classes\Core\ApiCollection;

/**
 * Call API and caches results.
 *
 * @category Core
 *
 */
class ApiCallBuilder
{
    /**
     * The ApiClient to use when calling
     * @var Eightfold\Eventbrite\Classes\Core\ApiClient The ApiClient connect to use
     *                                                  when making calls.
     */
    private $_client = null;

    /**
     * The endpoint to use when making calls.
     *
     * @var string
     */
    private $_endpoint = '';

    /**
     * The API SDK class to instantiate and return.
     *
     * @var string
     */
    private $_class = '';


    /**
     * Any API endpoints options and expansions to use when making calls.
     *
     * @var array
     */
    private $_options = [];

    /**
     * Whether to always return ApiCollection.
     *
     * @var boolean False assumes return is single resource.
     */
    private $_isCollection = false;

    /**
     * The key within the payload to convert to an ApiResource instance. `null` results
     * in trying to instantiate the class with the entire payload.
     *
     * @var string The key within the returned payload to instantiate.
     */
    private $_keyToInstantiate = null;

    /**
     * Array of payload keys to convert to local properties within an ApiCollection.
     *
     * @var array Returned payload keys to convert to properties within an
     *            ApiCollection.
     */
    private $_keysToConvertToCollectionVars = [];

    /**
     * The raw payload returned by the ApiClient.
     *
     * @var array
     */
    private $_payload = [];

    /**
     * @deprecated I am not sure this is still needed.
     *
     * @var string The raw return payload from the ApiClient.
     *
     */
    private $_raw;

    /**
     * What should be returned when asked.
     *
     * @var Eightfold\Eventbrite\Classes\Core\ApiCollection|Eightfold\Eventbrite\Classes\Core\ApiResource
     */
    private $_return;

    /**
     * Instantiate a call builder
     *
     * @param ApiClient   $client                        The ApiClient subclass to use
     *                                                   when performing calls.
     * @param string      $class                         The namespace of the class to
     *                                                   instantiate.
     * @param string      $endpoint                      The endpiont to use when
     *                                                   calling the API.
     * @param array       $options                       Associative array of
     *                                                   parameters to append to the
     *                                                   endpoint.
     * @param boolean     $isCollection                  When to always return an
     *                                                   ApiCollection not matter the
     *                                                   number of class instances.
     * @param string|null $keyToInstantiate              The key of the payload to
     *                                                   convert to instances of the
     *                                                   class.
     * @param array       $keysToConvertToCollectionVars Array of payload keys to
     *                                                   convert to instance variables.
     *
     * @category Initializer
     */
    public function __construct($client, $class, $endpoint, $options = [])
    {
        $this->_client = $client;
        $this->_class = $class;
        $this->_endpoint = $endpoint;
        $this->_options = $options;
        // $this->_keyToInstantiate = $keyToInstantiate;
        // $this->_keysToConvertToCollectionVars = $keysToConvertToCollectionVars;
    }

    public function get()
    {
        if ($this->hasReturnValue()) {
            return $this->_return;

        }

        $raw = $this->getRaw();

        if (is_string($raw)) {
            $this->_return = $this->_raw;

        } elseif (count($raw) == 0) {
            // got nothing make null
            $this->_return = [];

        }elseif ($this->hasCollectionClass()) {
            // got more than one, return the whole collection
            $this->_return = $this->_raw;

        } else {
            // gotta be one, return only the one
            $this->_return = $this->_raw[0];

        }

        return $this->_return;
    }

    /**
     * Return the first result within a collection, or the ApiResource itself.
     *
     * @return Eightfold\Eventbrite\Classes\Core\ApiCollection|Eightfold\Eventbrite\Classes\Core\ApiResource
     */
    public function first()
    {
        $result = $this->get();
        if (is_subclass_of($result, ApiCollection::class) && isset($result[0])) {
            return $result[0];
        }
        return $result;
    }

    /**
     * Return single ApiResource based on field containing the given value.
     *
     * @param  string     $field    Name of the field to check.
     * @param  string|int $contains What to run `==` comparison against.
     *
     * @return Eightfold\Eventbrite\Classes\Core\ApiResource|null
     *                              The ApiResource or ApiCollection that passes the
     *                              check. If not match is found, return null.
     */
    public function where($field, $contains)
    {
        // We don't have anything yet, make the call.
        if (is_null($this->_raw)) {
            $this->get();
        }
        if (is_a($this->_return, ApiCollection::class)) {
            $index = 0;
            foreach($this->_return as $item) {
                // TODO: Not sure what to do if can't convert to an array.
                $var = (array) $item->{$field};
                foreach($var as $check) {
                    if ($check === $contains) {
                        return $this->_return[$index];

                    }
                }
                $index++;
            }
        }
        return null;
    }

    /**
     * Clear cache of previous call.
     *
     * @return self Returns currents instance allow chaining:
     *              `$this->get()->reset()->get()`
     */
    public function reset()
    {
        $this->_return = null;
        $this->_raw = null;
        $this->_payload = null;
        return $this;
    }

    private function getRaw()
    {
        $payload = $this->getPayload();
        if ($this->hasRaw()) {
            return $this->_raw;

        }
        // print($this->_class .'Collection<br>');
        if ($this->hasCollectionClass()) {
            // print('using collection class<br>');
            $collectionClass = $this->_class .'Collection';
            $this->_raw = new $collectionClass($this->_client, $payload);

        } else {
            // print('using generic api collection<br>');
            $this->_raw = new ApiCollection($this->_client, $payload, $this->_class);
        }

        return $this->_raw;
    }

    private function getPayload()
    {
        if ($this->hasPayload()) {
            return $this->_payload;
        }
        $this->_payload = $this->_client->get($this->_endpoint, $this->_options);
        return $this->_payload;
    }

    private function hasCollectionClass()
    {
        return (class_exists($this->_class .'Collection'));
    }

    private function hasReturnValue()
    {
        return (isset($this->_return) && !is_null($this->_return));
    }

    private function hasRaw()
    {
        return (isset($this->_raw) && (!is_string($this->_raw)));
    }
    private function hasPayload()
    {
        return (is_array($this->_payload) && count($this->_payload) > 0);
    }
}
