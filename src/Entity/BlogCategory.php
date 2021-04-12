<?php

namespace App\Entity;

use App\Repository\BlogCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BlogCategoryRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class BlogCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     * @Assert\Length(min = 4, minMessage = "Le nom de la catégorie est trop court")
     * @Assert\Regex("/^\w+/")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex("/^\w+/", message="Caractères non valides")
     */
    private $category_icon;

    /**
     * @ORM\OneToMany(targetEntity=Blog::class, mappedBy="blog_category")
     */
    private $blog;

    public function __construct()
    {
        $this->blog = new ArrayCollection();
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

    public function getCategoryIcon(): ?string
    {
        return $this->category_icon;
    }

    public function setCategoryIcon(?string $category_icon): self
    {
        $this->category_icon = $category_icon;

        return $this;
    }

    /**
     * @return Collection|Blog[]
     */
    public function getBlog(): Collection
    {
        return $this->blog;
    }

    public function addBlog(Blog $blog): self
    {
        if (!$this->blog->contains($blog)) {
            $this->blog[] = $blog;
            $blog->setBlogCategory($this);
        }

        return $this;
    }

    public function removeBlog(Blog $blog): self
    {
        if ($this->blog->removeElement($blog)) {
            // set the owning side to null (unless already changed)
            if ($blog->getBlogCategory() === $this) {
                $blog->setBlogCategory(null);
            }
        }

        return $this;
    }
}
