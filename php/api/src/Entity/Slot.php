<?php

namespace App\Entity;

use Doctrine\DBAL\Types\DecimalType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SlotRepository")
 */
class Slot
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=64)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Pitch")
     * @ORM\JoinColumn(name="pitch_id")
     */

    private $pitch;
    /**
     * @ORM\Column(type="datetime")
     */

    private $starts;

    /**
     * @ORM\Column(type="datetime")
     */
    private $ends;

    /**
     * @ORM\Column(type="decimal", length=2)
     */
    private $price;


    /**
     * @ORM\Column(type="string", length=3)
     */
    private $currency;


    /**
     * @ORM\Column(type="boolean")
     */
    private $available;

    public function getId(): ?string
    {
        return $this->id;
    }


    public function setId(string $id): ?self
    {
        $this->id = $id;

        return $this;
    }

    public function getStarts(): ?\DateTime
    {
        return $this->starts;
    }

    public function setStarts(\DateTime $starts): self
    {
        $this->starts = $starts;

        return $this;
    }

    public function getPitch(): ?Pitch
    {
        return $this->pitch;
    }

    public function setPitch(Pitch $pitch): self
    {
        $this->pitch = $pitch;

        return $this;
    }

    public function getEnds(): ?\DateTime
    {
        return $this->ends;
    }

    public function setEnds(\DateTime $ends): self
    {
        $this->ends = $ends;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getAvailable(): ?bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): self
    {
        $this->available = $available;

        return $this;
    }
}
