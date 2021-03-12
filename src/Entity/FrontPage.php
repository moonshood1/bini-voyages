<?php

namespace App\Entity;

use App\Repository\FrontPageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FrontPageRepository::class)
 */
class FrontPage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $front_title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $front_introduction;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $front_main_image;

    /**
     * @ORM\Column(type="text")
     */
    private $front_footer_about;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $front_footer_location;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $front_footer_website;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $front_footer_contact_1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $front_footer_contact_2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $front_footer_email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $front_footer_facebook;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $front_footer_twitter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $front_footer_instagram;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFrontTitle(): ?string
    {
        return $this->front_title;
    }

    public function setFrontTitle(string $front_title): self
    {
        $this->front_title = $front_title;

        return $this;
    }

    public function getFrontIntroduction(): ?string
    {
        return $this->front_introduction;
    }

    public function setFrontIntroduction(string $front_introduction): self
    {
        $this->front_introduction = $front_introduction;

        return $this;
    }

    public function getFrontMainImage(): ?string
    {
        return $this->front_main_image;
    }

    public function setFrontMainImage(string $front_main_image): self
    {
        $this->front_main_image = $front_main_image;

        return $this;
    }

    public function getFrontFooterAbout(): ?string
    {
        return $this->front_footer_about;
    }

    public function setFrontFooterAbout(string $front_footer_about): self
    {
        $this->front_footer_about = $front_footer_about;

        return $this;
    }

    public function getFrontFooterLocation(): ?string
    {
        return $this->front_footer_location;
    }

    public function setFrontFooterLocation(string $front_footer_location): self
    {
        $this->front_footer_location = $front_footer_location;

        return $this;
    }

    public function getFrontFooterWebsite(): ?string
    {
        return $this->front_footer_website;
    }

    public function setFrontFooterWebsite(?string $front_footer_website): self
    {
        $this->front_footer_website = $front_footer_website;

        return $this;
    }

    public function getFrontFooterContact1(): ?string
    {
        return $this->front_footer_contact_1;
    }

    public function setFrontFooterContact1(string $front_footer_contact_1): self
    {
        $this->front_footer_contact_1 = $front_footer_contact_1;

        return $this;
    }

    public function getFrontFooterContact2(): ?string
    {
        return $this->front_footer_contact_2;
    }

    public function setFrontFooterContact2(?string $front_footer_contact_2): self
    {
        $this->front_footer_contact_2 = $front_footer_contact_2;

        return $this;
    }

    public function getFrontFooterEmail(): ?string
    {
        return $this->front_footer_email;
    }

    public function setFrontFooterEmail(string $front_footer_email): self
    {
        $this->front_footer_email = $front_footer_email;

        return $this;
    }

    public function getFrontFooterFacebook(): ?string
    {
        return $this->front_footer_facebook;
    }

    public function setFrontFooterFacebook(?string $front_footer_facebook): self
    {
        $this->front_footer_facebook = $front_footer_facebook;

        return $this;
    }

    public function getFrontFooterTwitter(): ?string
    {
        return $this->front_footer_twitter;
    }

    public function setFrontFooterTwitter(?string $front_footer_twitter): self
    {
        $this->front_footer_twitter = $front_footer_twitter;

        return $this;
    }

    public function getFrontFooterInstagram(): ?string
    {
        return $this->front_footer_instagram;
    }

    public function setFrontFooterInstagram(?string $front_footer_instagram): self
    {
        $this->front_footer_instagram = $front_footer_instagram;

        return $this;
    }
}
