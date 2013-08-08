<?php

namespace Fourt\Tests;

use Fourt\FourtClient;
use Guzzle\Log\ClosureLogAdapter;
use Guzzle\Plugin\Log\LogPlugin;
use Guzzle\Log\MessageFormatter;

class FourtTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FourtClient
     */
    protected $client;

    public function setUp()
    {
        $this->client = FourtClient::factory(
            array(
                'base_url' => 'https://api.sandbox.4-t.dk/',
                'developer_id' => 1,
                'public_key' => '5004f862-db37-488c-94ad-5dd76bfc5de1',
                'secret_key' => 'CFE327FF0B0525F27F099C9E0087B88E',
                'merchant_id' => 3
            )
        );
        $adapter = new ClosureLogAdapter(function ($m) { file_put_contents('trace.log',$m,\FILE_APPEND); });
        $logPlugin = new LogPlugin($adapter, MessageFormatter::DEBUG_FORMAT);
        $this->client->addSubscriber($logPlugin);
    }
}