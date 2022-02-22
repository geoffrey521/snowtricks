<?php

namespace App\Entity;

use App\Entity\traits\EntityTimestampableTrait;
use App\Model\EntityTimestampableInterface;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @UniqueEntity(fields={"email"}, message="There is already an user with this email")
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['email'])]
#[UniqueEntity(fields: ['username'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface, EntityTimestampableInterface
{
    use EntityTimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private string $email;

    #[ORM\Column(type: 'json')]
    /**
     * @var array<string>
     */
    private array $roles = [];

    #[ORM\Column(type: 'string')]
    #[Assert\Length(min: 8, max: 255)]
    private string $password;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 20)]
    private ?string $firstname;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\Length(max: 20)]
    private ?string $lastname;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $confirmToken;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private \DateTime $verifiedAt;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private string $resetToken;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private \DateTime $resetAt;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private string $rememberToken;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Trick::class)]
    private Collection $tricks;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $agreedTermsAt;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Assert\Length(max: 30)]
    private string $username;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private bool $isActive = false;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $avatarUrl;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $avatarPath;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->tricks = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->username;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array<string> $roles
     *
     * @return self
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /*public function getIsActive(): ?bool
    {
        return null !== $this->verifiedAt;
    }*/

    public function getConfirmToken(): ?string
    {
        return $this->confirmToken;
    }

    public function setConfirmToken(?string $confirmToken): self
    {
        $this->confirmToken = $confirmToken;

        return $this;
    }

    public function getVerifiedAt(): ?\DateTime
    {
        return $this->verifiedAt;
    }

    public function setVerifiedAt(?\DateTime $verifiedAt): self
    {
        $this->verifiedAt = $verifiedAt;

        return $this;
    }

    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    public function setResetToken(?string $resetToken): self
    {
        $this->resetToken = $resetToken;

        return $this;
    }

    public function getResetAt(): ?\DateTimeInterface
    {
        return $this->resetAt;
    }

    public function setResetAt(?\DateTime $resetAt): self
    {
        $this->resetAt = $resetAt;

        return $this;
    }

    public function getRememberToken(): ?string
    {
        return $this->rememberToken;
    }

    public function setRememberToken(?string $rememberToken): self
    {
        $this->rememberToken = $rememberToken;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Trick[]
     */
    public function getTricks(): Collection
    {
        return $this->tricks;
    }

    public function addTrick(Trick $trick): self
    {
        if (!$this->tricks->contains($trick)) {
            $this->tricks[] = $trick;
            $trick->setAuthor($this);
        }

        return $this;
    }

    public function removeTrick(Trick $trick): self
    {
        if ($this->tricks->removeElement($trick)) {
            // set the owning side to null (unless already changed)
            if ($trick->getAuthor() === $this) {
                $trick->setAuthor(null);
            }
        }

        return $this;
    }

    public function getAgreedTermsAt(): ?\DateTimeImmutable
    {
        return $this->agreedTermsAt;
    }

    public function setAgreedTermsAt(\DateTimeImmutable $agreedTermsAt): self
    {
        $this->agreedTermsAt = $agreedTermsAt;

        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(?bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }

    public function setAvatarUrl(?string $avatarUrl): self
    {
        $this->avatarUrl = $avatarUrl;

        return $this;
    }

    public function getAvatarPath(): ?string
    {
        return $this->avatarPath;
    }

    public function setAvatarPath(?string $avatarPath): self
    {
        $this->avatarPath = $avatarPath;

        return $this;
    }
}
