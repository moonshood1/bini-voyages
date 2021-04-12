<?php

namespace App\Entity;

use App\Repository\ListingCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ListingCategoryRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class ListingCategory
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
     * @ORM\OneToMany(targetEntity=Listing::class, mappedBy="listing_category")
     */
    private $listing;

    public function __construct()
    {
        $this->listing = new ArrayCollection();
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
     * @return Collection|Listing[]
     */
    public function getListing(): Collection
    {
        return $this->listing;
    }

    public function addListing(Listing $listing): self
    {
        if (!$this->listing->contains($listing)) {
            $this->listing[] = $listing;
            $listing->setListingCategory($this);
        }

        return $this;
    }

    public function removeListing(Listing $listing): self
    {
        if ($this->listing->removeElement($listing)) {
            // set the owning side to null (unless already changed)
            if ($listing->getListingCategory() === $this) {
                $listing->setListingCategory(null);
            }
        }

        return $this;
    }
}
