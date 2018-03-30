<?php
namespace AdminBundle\EventListener;

use AdminBundle\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class DefaultPasswordChangeListener implements EventSubscriberInterface {


    private $_tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->_tokenStorage = $tokenStorage;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        /**
         * @var $user User
         */
        $user = $request->getUser();
        //dump($user);
        /*if ($user->getIsDefaultPasswordChanged()) {
            echo 'ok';
        }*/


    }


    public static function getSubscribedEvents() {
        return array(
            // must be registered after the default Locale listener
            KernelEvents::REQUEST => array(array('onKernelRequest', 15)),
        );
    }


}