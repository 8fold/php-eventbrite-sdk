<?php

namespace Eightfold\Eventbrite\Classes\Core;

use Eightfold\Eventbrite\Classes\Core\Collection;

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
     * @deprecated
     * @var boolean
     */
    private $_isCollection = false;

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

    public function __construct($client, string $class, string $endpoint, array $options = [], $payload = [], $isCollection = false)
    {
        $this->_client = $client;
        $this->_class = $class;
        $this->_endpoint = $endpoint;
        $this->_options = $options;
        $this->_payload = $payload;
        $this->_isCollection = $isCollection;
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
        $this->_raw = new Collection($payload, $this->_client, $this->_class);
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