<?php
namespace Fourt\Event;

use Guzzle\Common\Event;
use Guzzle\Common\Collection;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\EntityEnclosingRequestInterface;
use Guzzle\Http\QueryString;
use Guzzle\Http\Url;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * 4T API signing
 * @package Fourt
 */
class SignatureListener implements EventSubscriberInterface
{
    /** @var Collection Configuration settings */
    protected $config;

    /**
     * Construct a new request signing plugin
     *
     * @param array $config Configuration array containing these parameters:
     *     - string 'public_key'           Public API key
     *     - string 'secret_key'           Private API key
     */
    public function __construct($config)
    {
        $this->config = Collection::fromConfig($config, array(), array(
            'public_key', 'secret_key'
        ));
    }

    public static function getSubscribedEvents()
    {
        return array(
            'request.before_send' => array('onRequestBeforeSend', -1000)
        );
    }

    /**
     * Get an array of headers to be signed
     *
     * @param RequestInterface $request Request to get headers from
     *
     * @return array
     */
    protected function getHeadersToSign(RequestInterface $request)
    {
        $headers = array();
        foreach ($request->getHeaders()->toArray() as $k => $v) {
            $k = strtolower($k);
            if (strpos($k, 'payment-') !== false) {
                $headers[$k] = $v;
            }
        }

        // Sort the headers alphabetically and add them to the string to sign
        ksort($headers);

        return $headers;
    }

    /**
     * Request before-send event handler
     *
     * @param Event $event Event received
     */
    public function onRequestBeforeSend(Event $event)
    {
        $request = $event['request']; /* @var $request EntityEnclosingRequestInterface */

        $sign = $request->getMethod() . "\n"
            . $request->getResource() . "\n";

        // Fix the date
        if ($request->hasHeader('Date')) {
            $sign .= $request->getHeader('Date') . "\n";
        } else {
            $date = gmdate('r', time());
            $request->setHeader('Date',$date);
            $sign .= $date . "\n";
        }

        // Add the body of the request if a body is present
        if ($request instanceof EntityEnclosingRequestInterface && ($request->getMethod() == 'POST' || $request->getMethod() == 'PUT')) {
            $sign .= $request->getHeader('Content-Type') . "\n";
            $md5 = $request->getBody()->getContentMd5(true,true);
            $sign .= $md5 . "\n";
            $request->setHeader('Content-MD5',$md5);
        } else {
            $request->removeHeader('Content-MD5');
            $request->removeHeader('Content-Type');
        }

        // Get all of the headers that must be signed (payment-*)
        $headers = $this->getHeadersToSign($request);
        foreach ($headers as $key => $value) {
            $sign .= $key . ':' . $value . "\n";
        }

        $signature = base64_encode(hash_hmac('sha256',trim($sign),$this->config->get('secret_key'),true));

        $request->setHeader('Authorization',$this->config->get('public_key').':'.$signature);
    }
}