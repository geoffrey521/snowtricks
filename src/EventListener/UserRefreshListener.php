<?php

namespace App\EventListener;

use App\Entity\User;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserRefreshListener
{
    public function __construct(private TokenStorageInterface $tokenStorage)
    {
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$entity instanceof User) {
            return;
        }

        $this->tokenStorage->getToken()->setUser($entity);
        dump($entity);
    }
}
