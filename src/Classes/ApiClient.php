<?php

namespace Eightfold\Eventbrite\Classes;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\BadResponseException;
use Psr\Http\Message\ResponseInterface;
use Exception;

/**
 * The main connection to the Eventbrite APIs
 *
 * Eventbrite only recognizes GET, POST, and DELETE.
 * 
 */
abstract class ApiClient
{
    /**
     * Version number for this package
     * @todo Consider deprecating
     */
    const version = '0.0.2';

    /**
     * Which version of the API to use
     */
    const base_uri = 'https://www.eventbriteapi.com/v3/';

    /**
     * @todo Consider deprecating
     */
    const user_endpoint = 'users/me/';
    
    /**
     * False by default allows us to handle errors
     */
    const exceptions = false;

    /**
     * How long to wait before timing out
     */
    const timeout = 30;

    /**
     * The OAuth token to use with the instance
     * @var string
     */
    private $token;

    /**
     * @var GuzzleHttp\Client
     */
    private $client;

    /**
     * Maps endpoint start with package class to return instance
     * @var dictionary
     */
    private $classMap = [
        'users'  => 'Eightfold\Eventbrite\Classes\Individual',
        'events' => 'Eightfold\Eventbrite\Classes\Event'
    ];

    /**
     * Create a new ApiCclient
     * 
     * @param string $token  The OAuth token for requests
     * @param array  $config Array of Guzzle config options
     *
     * @return ApiClient
     */
    static public function setAuthToken(string $token, $config = [])
    {
        return new Eventbrite($token, $config);
    }

    /**
     * Create a new ApiCclient
     * 
     * @param string $token  The OAuth token for requests
     * @param array  $config Array of Guzzle config options
     *
     * @throws \Excpetion
     */
    public function __construct($token, $config = [])
    {
        $default_config = [
            'base_uri' => self::base_uri,
            'exceptions' => self::exceptions,
            'timeout' => self::timeout,
        ];
        $config = array_merge($default_config, $config);

        // Add this last so it's always there and isn't overwritten.
        $config['headers']['User-Agent'] = '8fold\eventbrite-sdk-php v' . self::version . ' ' . \GuzzleHttp\default_user_agent();
        $config['headers']['Content-Type'] = 'application/json';

        if (!empty($token)) {
            $this->token = $token;
            // Set the authorisation header.
            $config['headers']['Authorization'] = 'Bearer ' . $this->token;
            $this->client = new Client($config);

        } else {
            throw new \Exception('An OAuth token is required to connect to the Eventbrite API.');

        }
    }

    /**
     * Get a resource from the API.
     *
     * GET calls do not require the token to be part of the endpoint.
     * 
     * @param  string      $endpoint The endpoint to hit on the API
     * @param  string|null $class    The desired class instance to be returned
     * @param  array       $options  Options to append to call
     * 
     * @return ApiResource           An instance of the class path received
     */
    public function get(string $endpoint, string $class = null, $options = [])
    {
        $class = $this->getClassPath($endpoint, $class);
        $response = $this->client->get($endpoint);
        if ($response instanceof ResponseInterface) {
            $body = $response->getBody()->getContents();
            $parsed = json_decode($body, true);
            $class = '\\'. $class;
            return new $class($parsed, $this);

        } else {
            throw new \Exception('Could not get resource.');

        }
    }

    /**
     * Update a resource with the API.
     *
     * POST calls require the token to be part of the endpoint.
     * 
     * @param  string      $endpoint The endpoint to hit on the API
     * @param  string|null $class    The desired class instance to be returned
     * @param  array       $options  The updates being made
     * 
     * @return ApiResource           An instance of the class path received
     */
    public function post(string $endpoint, string $class = null, $updates = [])
    {
        $endpoint = $endpoint .'/?token='. $this->token;
        $class = $this->getClassPath($endpoint, $class, $updates);

        $response = $this->client->post($endpoint, [
                'body' => json_encode($updates)
            ]);
        if ($response instanceof ResponseInterface) {
            $body = $response->getBody()->getContents();
            $parsed = json_decode($body, true);
            $class = '\\'. $class;
            return new $class($parsed, $this);

        } else {
            throw new \Exception('Could not patch resource.');

        }  
    }

    /**
     * Determine what class to instantiate upon return
     * 
     * @param  string      $endpoint The endpoint to use should `$class` be null
     * @param  string|null $class    The desired class instance to be returned
     * 
     * @return string                The resulting class path
     */
    public function getClassPath(string $endpoint, string $class = null)
    {
        if (is_null($class)) {
            // we were not told which class to instantiate,
            // use the endpoint to decide.
            $endpointParts = explode('/', $endpoint);    
            $object = $endpointParts[0];
            $class = (isset($this->classMap[$object]))
                ? $this->classMap[$object]
                : null;

        }
        return $class;
    }
}
