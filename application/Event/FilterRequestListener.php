<?php
namespace Sandbox\Event;

use Alchemy\Component\EventDispatcher\EventSubscriberInterface;
use Alchemy\Component\Http\Response;
use Alchemy\Kernel\KernelEvents;
use Alchemy\Kernel\Event\GetResponseEvent;
class FilterRequestListener implements EventSubscriberInterface
{
    public function onRequest(GetResponseEvent $event)
    {
        $response = new Response('response was filtered');
        $event->setResponse($response);
    }

    public static function getSubscribedEvents()
    {
        return array(KernelEvents::REQUEST => 'onRequest');
    }
}
