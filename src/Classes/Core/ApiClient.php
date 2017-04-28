<?php

namespace Eightfold\Eventbrite\Classes\Core;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\BadResponseException;
use Psr\Http\Message\ResponseInterface;
use Exception;

use Eightfold\Eventbrite\Traits\ClassMappable;

use Eightfold\Eventbrite\Classes\Helpers\Collection;

/**
 * The main connection to the Eventbrite APIs
 *
 * Eventbrite only recognizes GET, POST, and DELETE.
 *
 */
abstract class ApiClient
{
    use ClassMappable;

    /**
     * Which version of the API to use
     */
    const BASE_URI = 'https://www.eventbriteapi.com/v3';

    /**
     * @todo Consider deprecating
     */
    const USER_ENDPOINT = 'users/me';

    /**
     * False by default allows us to handle errors
     */
    const EXCEPTIONS = false;

    /**
     * How long to wait before timing out
     */
    const TIMEOUT = 30;

    /**
     * The OAuth token to use with the instance
     * @var string
     */
    private $token;

    /**
     * The configuration for each Guzzle client
     * @var array
     */
    private $config;

    /**
     * @var GuzzleHttp\Client
     */
    private $guzzle;

    /**
     * Create a new ApiCclient
     *
     * @param string $token  The OAuth token for requests
     * @param array  $config Array of Guzzle config options
     *
     * @return ApiClient
     */
    // static public function setAuthToken($token, $config = [])
    // {
    //     return new ApiClient($token, $config);
    // }

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
            'base_uri' => self::BASE_URI,
            'exceptions' => self::EXCEPTIONS,
            'timeout' => self::TIMEOUT
        ];
        $this->config = array_merge($default_config, $config);

        // Add this last so it's always there and isn't overwritten.
        $this->config['headers']['User-Agent'] = '8fold\eventbrite-sdk-php ' . \GuzzleHttp\default_user_agent();
        $this->config['headers']['Content-Type'] = 'application/json';

        if (!empty($token)) {
            $this->token = $token;
            $this->config['headers']['Authorization'] = 'Bearer ' . $this->token;
            $this->guzzle = new Client($this->config);

        } else {
            throw new \Exception('An OAuth token is required to connect to the Eventbrite API.');

        }
    }

    /**
     * [canConnect description]
     * @return [type] [description]
     */
    public function canConnect()
    {
        $endpoint = $this->buildFullEndpoint(self::USER_ENDPOINT);
        $response = $this->guzzle->get($endpoint);
        if ($response->getStatusCode() === 200) {
            return true;
        }
        return false;
    }

    /**
     * Get a resource from the API.
     *
     * GET calls do not require the token to be part of the endpoint.
     *
     * @param  string      $endpoint The endpoint to hit on the API
     * @param  array       $options  Options to append to call
     * @param  string|null $class    The desired class instance to be returned
     *
     * @return ApiResource           An instance of the class path received
     */
    public function get($endpoint, array $options = [], $class = null)
    {
        // @todo: Convert to try-catch
        $target = $this->buildFullEndpoint($endpoint, $options);
        $response = $this->guzzle->get($target);

        $class = $this->getRealClassPath($target, $class);

        // return the appropriate response
        if ($response instanceof ResponseInterface) {
            $body = $response->getBody()->getContents();
            $parsed = json_decode($body, true);
            if (isset($parsed['error_description'])) {
                return $parsed['error_description'];
            }
            return $parsed;

        } else {
            throw new \Exception('Could not get resource.');

        }
    }

    /**
     * Post a resource with the API.
     *
     * POST calls require the token to be part of the endpoint.
     *
     * @param  string      $endpoint The endpoint to hit on the API
     * @param  array       $options  The updates being made
     * @param  string|null $class    The desired class instance to be returned
     *
     * @return ApiResource           An instance of the class path received
     */
    public function post($endpoint, array $updates = [], $class = null)
    {
        // $endpoint = $this->buildFullEndpoint($endpoint, null);
        // $body = json_encode($updates);
        // $class = $this->getClassPath($endpoint, $class);
        // $response = $this->guzzle->post($endpoint, [
        //         'body' => $body
        //     ]);

        // if ($response instanceof ResponseInterface) {
        //     $body = $response->getBody()->getContents();
        //     $parsed = json_decode($body, true);
        //     $class = '\\'. $class;
        //     return new $class($parsed, $this);

        // } else {
        //     throw new \Exception('Could not post resource.');

        // }
    }

    private function buildFullEndpoint($endpoint, $options = [])
    {
        $options['token'] = $this->token;
        $base = static::BASE_URI .'/'. $endpoint .'/?';

        if (count($options) > 0) {
            $base .= $this->getParameters($options);
        }
        return $base;
    }

    /**
     * @todo Test to make sure this works.
     *
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    private function getParameters(array $options = [])
    {
        $params = [];
        foreach ($options as $key => $value)
        {
            $params[] = $key .'='. $value;
        }

        if (count($params) > 0) {
            $combined = implode('&', $params);
            return $combined;
        }
        return '';

    }

    /**
     * Determine what class to instantiate upon return
     *
     * @param  string      $endpoint The endpoint to use should `$class` be null
     * @param  string|null $class    The desired class instance to be returned
     *
     * @return string                The resulting class path
     */
    private function getRealClassPath($endpoint, $class = null)
    {
        if (is_null($class)) {
            print('apiClient->getRealClassPath - '. $endpoint .' is null');
            die('<br>deprecate the need for this<br>');
            // we were not told which class to instantiate,
            // use the endpoint to decide.
            $endpointParts = explode('/', $endpoint);
            $first = array_shift($endpointParts);
            $last = array_pop($endpointParts);
            $class = null;
            if (isset($this->classMap[$first])) {
                $class = $this->classMap[$object];

            } elseif (isset($this->classMap[$last])) {
                $class = $this->classMap[$last];

            }
        }
        return $class;
    }
}
