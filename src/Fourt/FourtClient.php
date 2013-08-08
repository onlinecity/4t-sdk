<?php
namespace Fourt;

use Guzzle\Common\Collection;
use Guzzle\Http\RedirectPlugin;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;

/**
 * Client to interact with the 4-T API
 *
 * @method \Guzzle\Service\Resource\Model createTransaction(array $args = array())
 * @method \Guzzle\Service\Resource\Model invalidateTransaction(array $args = array())
 * @method \Guzzle\Service\Resource\Model getTransaction(array $args = array())
 * @method \Guzzle\Service\Resource\Model authorize(array $args = array())
 * @method \Guzzle\Service\Resource\Model capture(array $args = array())
 * @method \Guzzle\Service\Resource\Model cancel(array $args = array())
 * @method \Guzzle\Service\Resource\Model immediateCapture(array $args = array())
 * @method \Guzzle\Service\Resource\Model refund(array $args = array())
 * @method \Guzzle\Service\Resource\Model sendMessage(array $args = array())
 * @method \Guzzle\Service\Resource\Model getMessage(array $args = array())
 */
class FourtClient extends Client
{
    public static function factory($config = array())
    {
        // Provide a hash of default client configuration options
        $default = array('base_url' => 'https://api.4-t.dk/');

        // The following values are required when creating the client
        $required = array(
            'developer_id',
            'public_key',
            'secret_key',
            'merchant_id'
        );

        // Merge in default settings and validate the config
        $config = Collection::fromConfig($config, $default, $required);

        // Create a new 4T client
        $client = new self($config->get('base_url'), $config);

        // Ensure that the SignatureListener is attached to the client
        $client->addSubscriber(new Event\SignatureListener($config->toArray()));

        // We need redirection support for non-3xx responses
        $client->addSubscriber(new Event\RedirectListener());

        // Improve the exceptions
        $client->addSubscriber(new Event\ExceptionListener());

        // Set service description
        $client->setDescription(ServiceDescription::factory(__DIR__.DIRECTORY_SEPARATOR.'config.php'));

        return $client;
    }

}