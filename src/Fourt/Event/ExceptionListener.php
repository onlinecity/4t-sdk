<?php
namespace Fourt\Event;

use Guzzle\Common\Event;
use Guzzle\Common\Collection;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Fourt\FourtException;

class ExceptionListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            'request.error'        => array('onRequestError',-1),
        );
    }

    /**
     * Called when a request receives a redirect response
     *
     * @param Event $event Event emitted
     */
    public function onRequestError(Event $event)
    {
        $response = $event['response']; /* @var $response Response */
        $request = $event['request']; /* @var $request RequestInterface */

        if ($response && ($response->getStatusCode() == 400 || $response->getStatusCode() == 500) && $response->isContentType('application/json')) {
            $event->stopPropagation();
            $e = FourtException::factory($request,$response);
            throw $e;
        }
    }
}