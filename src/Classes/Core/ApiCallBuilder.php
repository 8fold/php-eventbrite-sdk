<?php

namespace Eightfold\Eventbrite\Classes\Core;

use Eightfold\Eventbrite\Classes\Core\ApiCollection;

class ApiCallBuilder
{
    /**
     * The ApiClient to use when calling
     * @var null
     */
    private $_client = null;

    /**
     * The class path for the endpoint
     * @var string
     */
    private $_class = '';

    /**
     * The endpoint to use when making calls
     * @var string
     */
    private $_endpoint = '';

    /**
     * Any options and expansions to use when making calls
     * @var array
     */
    private $_options = [];

    /**
     * Whethed to always return Collection
     * @var boolean
     */
    private $_isCollection = false;

    /**
     * The key within the payload to convert to instance of ApiResource. Null results
     * in trying to instantiate the class with the entire payload.
     * @var string
     */
    private $_keyToInstantiate = null;

    /**
     * Array of payload keys to convert to local variables within the ApiCollection
     * @var array
     */
    private $_keysToConvertToCollectionVars = [];
    /**
     * * The payload returned by the ApiClient
     * @var array
     */
    private $_payload = [];

    /**
     * @deprecated ??
     * @var Collection
     */
    private $_raw;

    /**
     * What to return when asked
     * @var [type]
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
     */
    public function __construct(
        $client, 
        string $class, 
        string $endpoint, 
        array $options = [], 
        $isCollection = false, 
        string $keyToInstantiate = null, 
        $keysToConvertToCollectionVars = [])
    {
        $this->_client = $client;
        $this->_class = $class;
        $this->_endpoint = $endpoint;
        $this->_options = $options;
        $this->_isCollection = $isCollection;
        $this->_keyToInstantiate = $keyToInstantiate;
        $this->_keysToConvertToCollectionVars = $keysToConvertToCollectionVars;
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
        
        }elseif ($this->_isCollection || count($raw) > 1) {
            // got more than one, return the whole collection
            $this->_return = $this->_raw;

        } else {
            // gotta be one, return only the one
            $this->_return = $this->_raw[0];

        }

        return $this->_return;
    }

    public function first()
    {
        $result = $this->get();
        if (count($result) > 1) {
            return $result[0];
        }
        return $result;
    }

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
        if (class_exists($this->_class .'Collection')) {
            // print('using collection class<br>');
            $collectionClass = $this->_class .'Collection';
            $this->_raw = new $collectionClass($payload, $this->_client);            

        } else {
            // print('using generic api collection<br>');
            $this->_raw = new ApiCollection($payload, $this->_client, $this->_class, $this->_keyToInstantiate, $this->_keysToConvertToCollectionVars);            
        }

        return $this->_raw;
    }

    private function getPayload()
    {
        if ($this->hasPayload()) {
            return $this->_payload;
        }
        $this->_payload = $this->_client->get($this->_endpoint, $this->_options, $this->_class);
        return $this->_payload;
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