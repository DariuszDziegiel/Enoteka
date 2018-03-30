<?php
namespace AppBundle\EventListener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;


class TestSubscriber implements EventSubscriberInterface {
    
    
    public function onKernelRequest(GetResponseEvent $event) {
        $request = $event->getRequest();
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [
                [
                    'onKernelRequest'
                ]
            ]
        ];
    }
    
}