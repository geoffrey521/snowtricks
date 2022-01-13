<?php

namespace App\EventListener;

use App\Model\EntitySlugInterface;
use App\Model\EntityTimestampableInterface;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\String\Slugger\SluggerInterface;

class DoctrineSubscribe implements EventSubscriberInterface
{
    public function __construct(private SluggerInterface $slugger){}

    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $object = $eventArgs->getObject();
        if ($object instanceof EntityTimestampableInterface) {
            $object->setCreatedAt();
        }
        if ($object instanceof EntitySlugInterface) {
            $object->computeSlug($this->slugger);
        }
    }

    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $object = $eventArgs->getObject();
        if ($object instanceof EntityTimestampableInterface) {
            $object->setUpdatedAt();
        }
        if ($object instanceof EntitySlugInterface) {
            $object->computeSlug($this->slugger);
        }
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate
        ];
    }
}