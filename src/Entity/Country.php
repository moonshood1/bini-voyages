<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=CountryRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 *  fields = {"name"},
 *  message = "Ce pays a déja été créé ."
 * )
 */
class Country
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
     * @Assert\Length(max =3, maxMessage = "Le nom du pays est trop long , veuillez utilisez les initiales")
     * @Assert\Regex("/^\w+/")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Listing::class, mappedBy="country")
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
            $listing->setCountry($this);
        }

        return $this;
    }

    public function removeListing(Listing $listing): self
    {
        if ($this->listing->removeElement($listing)) {
            // set the owning side to null (unless already changed)
            if ($listing->getCountry() === $this) {
                $listing->setCountry(null);
            }
        }

        return $this;
    }
}
