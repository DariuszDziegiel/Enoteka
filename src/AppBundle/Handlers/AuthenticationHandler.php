<?php
namespace AppBundle\Handlers;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

class AuthenticationHandler implements LogoutSuccessHandlerInterface, AuthenticationFailureHandlerInterface, AuthenticationSuccessHandlerInterface
{

    /**
     * Login fail handler
     * @param Request $request
     * @param AuthenticationException $exception
     * @return RedirectResponse
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $referer = $request->headers->get('referer');
        $request->getSession()->getFlashBag()->add('loginError', $exception->getMessage());
        return new RedirectResponse($referer);
    }

    /**
     * Login success handler
     * @param Request $request
     * @param TokenInterface $token
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $referer = $request->headers->get('referer');
        $request->getSession()->getFlashBag()->add('loginSuccess', true);
        return new RedirectResponse($referer);
    }

    /**
     * Logout handler
     * @param Request $request
     * @return RedirectResponse
     */
    public function onLogoutSuccess(Request $request)
    {
        $referer = $request->headers->get('referer');
        return new RedirectResponse($referer);
    }



}
