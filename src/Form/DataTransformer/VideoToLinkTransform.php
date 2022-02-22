<?php

namespace App\Form\DataTransformer;

use App\Entity\Video;
use App\Repository\VideoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\DataTransformerInterface;

class VideoToLinkTransform implements DataTransformerInterface
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function transform($value)
    {
        if (null === $value) {
            return [];
        }

        return $value->map(function (Video $video) {
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
