<?php
/**
 * Created by PhpStorm.
 * User: robm
 * Date: 20/09/2019
 * Time: 21:22
 */

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PitchRepository")
 * @ORM\Table(indexes={@ORM\Index(columns={"id"})})
 * @ORM\HasLifecycleCallbacks

 */
class Pitch
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $sport;

    /**
     * @ORM\OneToMany(targetEntity="Slot", mappedBy="pitch")
     */

    private $slots;

    public function __construct()
    {
        $this->slots = new ArrayCollection();
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

    public function getSport(): ?string
    {
        return $this->sport;
    }

    public function setSport(string $sport): self
    {
        $this->sport = $sport;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlots()
    {
        return $this->slots;
    }

    /**
     * @param mixed $slots
     */
    public function setSlots($slots)
    {
        $this->slots = $slots;
    }
}