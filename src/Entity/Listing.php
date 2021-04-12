<?php

namespace App\Entity;

use App\Repository\ListingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ListingRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Listing
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
     * @Assert\Length(min = 10, minMessage = "Le titre du ciruit est trop court")
     * @Assert\Regex("/^\w+/")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     * @Assert\Length(min = 10, minMessage = "L'emplacement du circuit est trop court")
     * @Assert\Regex("/^\w+/")
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     * @Assert\Length(max = 10, maxMessage = "Le contact doit avoir 10 chiffres")
     * @Assert\Regex("/^\w+/")
     */
    private $contact;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     * @Assert\Length(min = 50, minMessage = "La descriptioon du circuit est trop courte")
     * @Assert\Regex("/^\w+/")
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     * @Assert\Url(message = "la valeur '{{ value }}' n'est pas une URL valide")
     */
    private $main_image;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="listings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="listing")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=ListingImage::class, mappedBy="listing")
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity=Booking::class, mappedBy="listing")
     */
    private $bookings;

    /**
     * @ORM\ManyToOne(targetEntity=ListingCategory::class, inversedBy="listing")
     * @ORM\JoinColumn(nullable=false)
     */
    private $listing_category;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isOpen;

    /**
     * @ORM\ManyToOne(targetEntity=ListingCity::class, inversedBy="listing")
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="listing")
     */
    private $country;

    /**
     * @ORM\PrePersist
     */
    public function prePersistCreatedAt() 
    {
        if (empty($this->createdAt)) {
            $this->createdAt = new \DateTime();
        }
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersistisOpen() 
    {
        if (empty($this->isOpen)) {
            $this->isOpen = true;
        }
    }

    

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->bookings = new ArrayCollection();
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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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
            $comment->setListing($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getListing() === $this) {
                $comment->setListing(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ListingImage[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(ListingImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setListing($this);
        }

        return $this;
    }

    public function removeImage(ListingImage $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getListing() === $this) {
                $image->setListing(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setListing($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getListing() === $this) {
                $booking->setListing(null);
            }
        }

        return $this;
    }

    public function getListingCategory(): ?ListingCategory
    {
        return $this->listing_category;
    }

    public function setListingCategory(?ListingCategory $listing_category): self
    {
        $this->listing_category = $listing_category;

        return $this;
    }

    public function getIsOpen(): ?bool
    {
        return $this->isOpen;
    }

    public function setIsOpen(bool $isOpen): self
    {
        $this->isOpen = $isOpen;

        return $this;
    }

    public function getCity(): ?ListingCity
    {
        return $this->city;
    }

    public function setCity(?ListingCity $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }
}
