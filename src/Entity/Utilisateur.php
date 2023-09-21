<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'id_user', targetEntity: Commentaire::class)]
    private Collection $commentaires;

    #[ORM\ManyToMany(targetEntity: Commentaire::class, inversedBy: 'utilisateurs')]
    private Collection $like_commentaire;

    #[ORM\ManyToMany(targetEntity: Article::class, inversedBy: 'utilisateurs')]
    private Collection $likeArticle;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->like_commentaire = new ArrayCollection();
        $this->likeArticle = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
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
        return (string) $this->email;
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

    public function setRoles(array $roles): static
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

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setIdUser($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getIdUser() === $this) {
                $commentaire->setIdUser(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return $this->email;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getLikeCommentaire(): Collection
    {
        return $this->like_commentaire;
    }

    public function addLikeCommentaire(Commentaire $likeCommentaire): static
    {
        if (!$this->like_commentaire->contains($likeCommentaire)) {
            $this->like_commentaire->add($likeCommentaire);
        }

        return $this;
    }

    public function removeLikeCommentaire(Commentaire $likeCommentaire): static
    {
        $this->like_commentaire->removeElement($likeCommentaire);

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getLikeArticle(): Collection
    {
        return $this->likeArticle;
    }

    public function addLikeArticle(Article $likeArticle): static
    {
        if (!$this->likeArticle->contains($likeArticle)) {
            $this->likeArticle->add($likeArticle);
        }

        return $this;
    }

    public function removeLikeArticle(Article $likeArticle): static
    {
        $this->likeArticle->removeElement($likeArticle);

        return $this;
    }
}
