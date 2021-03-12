<?php

namespace App\Entity;

use App\Repository\GuidesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GuidesRepository::class)
 */
class Guides
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
    private $guide_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $guide_picture;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGuideName(): ?string
    {
        return $this->guide_name;
    }

    public function setGuideName(string $guide_name): self
    {
        $this->guide_name = $guide_name;

        return $this;
    }

    public function getGuidePicture(): ?string
    {
        return $this->guide_picture;
    }

    public function setGuidePicture(string $guide_picture): self
    {
        $this->guide_picture = $guide_picture;

        return $this;
    }
}
