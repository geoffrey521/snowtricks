<?php

namespace App\Entity\traits;

use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\ORM\Mapping as ORM;

trait EntitySlugTrait
{
    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private ?string $slug = null;

    public function computeSlug(SluggerInterface $slugger)
    {
        if (!$this->slug || '-' === $this->slug) {
           $this->slug = (string)$slugger->slug((string)$this)->lower();
       }
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

}