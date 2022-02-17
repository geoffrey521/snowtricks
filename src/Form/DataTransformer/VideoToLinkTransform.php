<?php

namespace App\Form\DataTransformer;

use App\Entity\Video;
use App\Repository\VideoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class VideoToLinkTransform implements DataTransformerInterface
{
    public function __construct(private VideoRepository $videoRepository) {

    }

    public function transform($videos)
    {
        if (null === $videos) {
            return [];
        }
        return $videos->map(function (Video $video) {
            return $video->getUrl();
        })->toArray();
    }

    public function reverseTransform($urls)
    {
        if (empty($urls)) {
            return null;
        }
        $videoCollection = new ArrayCollection();

        foreach ($urls as $url) {
            if (empty($url)) {
                continue;
            }

            $video = $this->videoRepository->findOneBy(['url' => $url]);

            if (null === $video) {
                $video = new Video();
                $video->setUrl($url);
            }
            $videoCollection->add($video);
        }
        return $videoCollection;
    }
}