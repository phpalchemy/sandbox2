<?php
namespace Sandbox\Event;

use Alchemy\Component\EventDispatcher\EventSubscriberInterface;

class BeforeResponseEvent implements EventSubscriberInterface
{
    public function onResponse()
    {
        echo 'on response from event suscriber';
    }

    public static function getSubscribedEvents()
    {
        return array(Kernel::BEFORE_RESPONSE => 'onResponse');
    }
}
