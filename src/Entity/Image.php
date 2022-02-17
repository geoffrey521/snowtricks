<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Image(
        mimeTypes: ['image/jpeg', 'image/jpg', 'image/png'],
        mimeTypesMessage: 'this file extension in not valid, please select a .jpg, .jpeg or .png file'
    )]
    #[Assert\NotBlank]
    private string $title;

    #[ORM\Column(type: 'string', length: 255)]
    private string $caption;

    #[ORM\ManyToOne(targetEntity: Trick::class, inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: true)]
    private Trick $trick;

    #[ORM\Column(type: 'string', length: 255)]
    private string $path;

    public function __toString(): string
    {
        return $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCaption(): ?string
    {
        return $this->caption;
    }

    public function setCaption(string $caption): self
    {
        $this->caption = $caption;

        return $this;
    }

    public function getTrick(): ?Trick
    {
        return $this->trick;
    }

    public function setTrick(?Trick $trick): self
    {
        $this->trick = $trick;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }
}
