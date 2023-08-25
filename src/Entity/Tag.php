<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Article::class, inversedBy: 'tags')]
    private Collection $tagArticle;

    public function __construct()
    {
        $this->tagArticle = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getTagArticle(): Collection
    {
        return $this->tagArticle;
    }

    public function addTagArticle(Article $tagArticle): static
    {
        if (!$this->tagArticle->contains($tagArticle)) {
            $this->tagArticle->add($tagArticle);
        }

        return $this;
    }

    public function removeTagArticle(Article $tagArticle): static
    {
        $this->tagArticle->removeElement($tagArticle);

        return $this;
    }
}
