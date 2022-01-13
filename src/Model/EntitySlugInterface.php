<?php

namespace App\Model;

use Symfony\Component\String\Slugger\SluggerInterface;

interface EntitySlugInterface
{
    public function __toString(): string;

    public function computeSlug(SluggerInterface $slugger);
}
