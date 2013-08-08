<?php
namespace Fourt\Event;

use Guzzle\Common\Event;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;
use Guzzle\Http\RedirectPlugin;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RedirectListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            'request.sent'        => array('onRequestSent',101),
        );
    }

    /**
     * Called when a request receives a redirect response
     *
     * @param Event $event Event emitted
     */
    public function onRequestSent(Event $event)
    {
        $response = $event['response']; /* @var $response Response */
        $request = $event['request']; /* @var $request RequestInterface */

        // Only act on redirect requests with Location headers
        if (!$response || $request->getParams()->get(RedirectPlugin::DISABLE)) {
            return;
        }

        // Our API returns a location redirect but not a 3xx status code, which guzzle won't process
        // Also don't include the body on the redirect
        if (!$response->isRedirect() && $response->hasHeader('Location')) {
            $response->setStatus(302);
        }
    }
}