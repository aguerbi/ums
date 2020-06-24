<?php

namespace App\Entity;

use App\Repository\CardRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CardRepository::class)
 */
class Card {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numberCard;

    /**
     * @ORM\Column(type="datetime")
     */
    private $delivery_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $year;

    /**
     * @ORM\ManyToOne(targetEntity=Adherent::class, inversedBy="cards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adherent;

    public function __construct() {
        return $this->delivery_at = new \DateTime('now');
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getNumberCard(): ?string {
        return $this->numberCard;
    }

    public function setNumberCard(string $numberCard): self {
        $this->numberCard = $numberCard;

        return $this;
    }

    public function getDeliveryAt(): ?\DateTimeInterface {
        return $this->delivery_at;
    }

    public function setDeliveryAt(\DateTimeInterface $delivery_at): self {
        $this->delivery_at = $delivery_at;

        return $this;
    }

    public function getYear(): ?string {
        return $this->year;
    }

    public function setYear(string $year): self {
        $this->year = $year;

        return $this;
    }

    public function getAdherent(): ?Adherent {
        return $this->adherent;
    }

    public function setAdherent(?Adherent $adherent): self {
        $this->adherent = $adherent;

        return $this;
    }

}
