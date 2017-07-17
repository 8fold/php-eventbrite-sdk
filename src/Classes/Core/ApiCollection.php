<?php

namespace Eightfold\Eventbrite\Classes\Core;

use ArrayObject;

// TODO: Rename to ApiResourceCollection
/**
 * Hold multiple ApiResources
 *
 * @category Core
 *
 * @todo  Consider making a factory for collections.
 */
abstract class ApiCollection extends ArrayObject
{
    /**
     * Instantiate ApiCollection using given payload.
     *
     * For a collection of resources returned from the API, there is usually a key
     * that has as its value the array of individual objects return from the API.
     *
     * Therefore, we want to tell the ApiCollection, where within the JSON return the
     * collection of objects resides.
     *
     * Sometimes we also receive data outside the array of whatever objects we have a
     * collection of (attendees for this example). If you would like the values of
     * those members stored in the instance, pass an array of the keys (member names)
     * when you instantiate an ApiCollection. They will be made public properties on
     * the instance.
     *
     * @param array     $payload                  The JSON decoded return from an API
     *                                            call.
     * @param ApiClient $client                   The API connection to use.
     * @param string    $class                    The class name to instantiate when
     *                                            building the collection.
     * @param string    $keyToInstantiate         See description.
     * @param array     $keysToConvertToLocalVars See description.
     */
    // public function __construct($client, $payload, $class, $keyToInstantiate = null, $keysToConvertToLocalVars = []) {
    //     if (!is_null($keysToConvertToLocalVars) && is_array($keysToConvertToLocalVars)) {
    //         foreach($keysToConvertToLocalVars as $convertMe) {
    //             if (isset($payload->$convertMe)) {
    //                 $this->{$convertMe} = $payload->$convertMe;
    //                 unset($payload->$convertMe);
    //             }
    //         }
    //     }

    //     if (!is_null($keyToInstantiate) && isset($payload->$keyToInstantiate)) {
    //         $array = [];
    //         foreach($payload->$keyToInstantiate as $resourcePayload) {
    //             $array[] = new $class($resourcePayload, $client);
    //         }
    //         parent::__construct($array);

    //     } else {
    //         $single = new $class($client, $payload);
    //         parent::__construct([$single]);
    //     }
    // }

    private $client;

    private $endpoint;

    private $pagination;

    private $raw;

    public function __construct($client, $endpoint, $payloadKey, $className, $options = [])
    {
        // Cache the client.
        $this->client = $client;

        // Cache the endpoint.
        $this->endpoint = $endpoint;

        // Get the payload.
        $payload = $this->client->get($endpoint);
        if (isset($payload['pagination'])) {
            // Remove pagination from payload.
            $this->pagination = $payload['pagination'];
            unset($payload['pagination']);

        }
        die(var_dump($payload));

        $array = [];
        foreach ($payload[$payloadKey] as $entry) {
            $array[] = new $className($this->client, $entry);

        }
        parent::__construct($array);
    }

    public function rewind() {
        // var_dump(__METHOD__);
        $this->position = 0;
    }

    public function current() {
        // var_dump(__METHOD__);
        return $this->array[$this->position];
    }

    public function key() {
        // var_dump(__METHOD__);
        return $this->position;
    }

    public function next() {
        // var_dump(__METHOD__);
        ++$this->position;
    }

    public function valid() {
        // var_dump(__METHOD__);
        return isset($this->array[$this->position]);
    }
}
