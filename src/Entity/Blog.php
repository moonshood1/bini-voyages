<?php

namespace App\Entity;

use App\Repository\BlogRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BlogRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Blog
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
     * @Assert\Length(min = 20, minMessage = "Le titre de l'article est trop court")
     * @Assert\Regex("/^\w+/")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     * @Assert\Length(min = 50, minMessage = "Le texte de l'article est trop court")
     */
    private $content;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content_2;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content_3;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     * @Assert\Url(message = "la valeur '{{ value }}' n'est pas une URL valide")
     */
    private $main_image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $second_image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $third_image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fourth_image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fifth_image;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="blogs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=BlogCategory::class, inversedBy="blog")
     */
    private $blog_category;

    /**
     * @ORM\PrePersist
     */
    public function prePersistCreatedAt()
    {
        if (empty($this->createdAt)) {
            $this->createdAt = new \DateTime();
        }
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getContent2(): ?string
    {
        return $this->content_2;
    }

    public function setContent2(?string $content_2): self
    {
        $this->content_2 = $content_2;

        return $this;
    }

    public function getContent3(): ?string
    {
        return $this->content_3;
    }

    public function setContent3(?string $content_3): self
    {
        $this->content_3 = $content_3;

        return $this;
    }

    public function getMainImage(): ?string
    {
        return $this->main_image;
    }

    public function setMainImage(string $main_image): self
    {
        $this->main_image = $main_image;

        return $this;
    }

    public function getSecondImage(): ?string
    {
        return $this->second_image;
    }

    public function setSecondImage(?string $second_image): self
    {
        $this->second_image = $second_image;

        return $this;
    }

    public function getThirdImage(): ?string
    {
        return $this->third_image;
    }

    public function setThirdImage(?string $third_image): self
    {
        $this->third_image = $third_image;

        return $this;
    }

    public function getFourthImage(): ?string
    {
        return $this->fourth_image;
    }

    public function setFourthImage(?string $fourth_image): self
    {
        $this->fourth_image = $fourth_image;

        return $this;
    }

    public function getFifthImage(): ?string
    {
        return $this->fifth_image;
    }

    public function setFifthImage(?string $fifth_image): self
    {
        $this->fifth_image = $fifth_image;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getBlogCategory(): ?BlogCategory
    {
        return $this->blog_category;
    }

    public function setBlogCategory(?BlogCategory $blog_category): self
    {
        $this->blog_category = $blog_category;

        return $this;
    }
}
