<?php

namespace App\Entity;

use App\Repository\AdherentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdherentRepository::class)
 */
class Adherent {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cin;

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
    private $mobile;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="adherents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $company;

    /**
     * @ORM\OneToMany(targetEntity=Card::class, mappedBy="adherent", orphanRemoval=true)
     */
    private $cards;

    public function __construct()
    {
        $this->cards = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getFirstName(): ?string {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self {
        $this->lastName = $lastName;

        return $this;
    }

    public function getCin(): ?string {
        return $this->cin;
    }

    public function setCin(string $cin): self {
        $this->cin = $cin;

        return $this;
    }

    public function getNumberCard(): ?string {
        return $this->numberCard;
    }

    public function setNumberCard(string $numberCard): self {
        $this->numberCard = $numberCard;

        return $this;
    }

    public function getMobile(): ?string {
        return $this->mobile;
    }

    public function setMobile(string $mobile): self {
        $this->mobile = $mobile;

        return $this;
    }

    public function getDeliveryAt(): ?\DateTimeInterface {
        return $this->delivery_at;
    }

    public function setDeliveryAt(\DateTimeInterface $delivery_at): self {
        $this->delivery_at = $delivery_at;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection|Card[]
     */
    public function getCards(): Collection
    {
        return $this->cards;
    }

    public function addCard(Card $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards[] = $card;
            $card->setAdherent($this);
        }

        return $this;
    }

    public function removeCard(Card $card): self
    {
        if ($this->cards->contains($card)) {
            $this->cards->removeElement($card);
            // set the owning side to null (unless already changed)
            if ($card->getAdherent() === $this) {
                $card->setAdherent(null);
            }
        }

        return $this;
    }

}
