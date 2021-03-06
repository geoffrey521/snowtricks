<?php

namespace App\EventListener;

use App\Entity\Video;
use App\Service\FormatVideo;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class VideoSubscribe implements EventSubscriberInterface
{
    public function __construct(private FormatVideo $formatVideo)
    {
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->setExtraInfos($args->getObject());
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $this->setExtraInfos($args->getObject());
    }

    private function setExtraInfos($video)
    {
        // if this listener only applies to certain entity types,
        // add some code to check the entity type as early as possible
        if (!$video instanceof Video) {
            return;
        }

        $videoDatas = $this->formatVideo->formatVideoDatasFromUrl($video->getUrl());

        if ($videoDatas) {
            $video->setUrl($videoDatas['url']);
            $video->setThumbnail($videoDatas['thumbnail']);
            $video->setTrick($video->getTrick());
        }
    }
}
