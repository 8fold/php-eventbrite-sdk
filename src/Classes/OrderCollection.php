<?php

namespace Eightfold\Eventbrite\Classes;

use Eightfold\Eventbrite\Classes\Core\ApiCollection;

use Eightfold\Eventbrite\Classes\Order;

/**
 * @package Collections
 */
class OrderCollection extends ApiCollection
{
    // private $client;

    // private $endpoint;

    // private $options;

    // private $pagination;

    // private $raw;

    public function __construct($client, $endpoint, $options)
    {
        parent::__construct($client, $endpoint, 'orders', Order::class, $options);
        // $this->client = $client;

        // $this->endpoint = $endpoint;

        // $this->options = $options;

        // $payload = $this->client->get($endpoint, $options);
        // if (isset($payload['pagination'])) {
        //     $this->pagination = $payload['pagination'];
        //     unset($payload['pagination']);

        // }

        // $array = [];
        // foreach ($payload['orders'] as $order) {
        //     $array[] = new Order($this->client, $order);

        // }
        // parent::__construct($array);
    }
}
