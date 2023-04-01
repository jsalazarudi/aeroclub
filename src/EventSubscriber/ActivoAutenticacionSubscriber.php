<?php

namespace App\EventSubscriber;

use App\Entity\Tesorero;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;

class ActivoAutenticacionSubscriber implements EventSubscriberInterface
{
    public function onSecurityAuthenticationSuccess(AuthenticationSuccessEvent $event): void
    {
        /** @var Tesorero|UserInterface $user */
        $user = $event->getAuthenticationToken()->getUser();
        if($user->isActivo() === false){
            throw new AuthenticationException('El usuario esta inactivo');
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'security.authentication.success' => 'onSecurityAuthenticationSuccess',
        ];
    }
}
