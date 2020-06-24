<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CompanyRepository::class)
 */
class Company {

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
     * @Assert\Length(
     *      min = 8,
     *      max = 11
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @Assert\Length(
     *      min = 8,
     *      max = 11
     * )
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fax;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $director;

    /**
     * @Assert\Length(
     *      min = 8,
     *      max = 11
     * )
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mobile;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity=Adherent::class, mappedBy="company", orphanRemoval=true)
     */
    private $adherents;

    /**
     * @ORM\OneToMany(targetEntity=Syndicat::class, mappedBy="company", orphanRemoval=true)
     */
    private $syndicats;

    public function __construct() {
        return $this->created_at = new \DateTime('now');
        $this->adherents = new ArrayCollection();
        $this->syndicats = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;

        return $this;
    }

    public function getPhone(): ?string {
        return $this->phone;
    }

    public function setPhone(string $phone): self {
        $this->phone = $phone;

        return $this;
    }

    public function getFax(): ?string {
        return $this->fax;
    }

    public function setFax(string $fax): self {
        $this->fax = $fax;

        return $this;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(string $email): self {
        $this->email = $email;

        return $this;
    }

    public function getAddress(): ?string {
        return $this->address;
    }

    public function setAddress(string $address): self {
        $this->address = $address;

        return $this;
    }

    public function getDirector(): ?string {
        return $this->director;
    }

    public function setDirector(string $director): self {
        $this->director = $director;

        return $this;
    }

    public function getMobile(): ?string {
        return $this->mobile;
    }

    public function setMobile(string $mobile): self {
        $this->mobile = $mobile;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|Adherent[]
     */
    public function getAdherents(): Collection
    {
        return $this->adherents;
    }

    public function addAdherent(Adherent $adherent): self
    {
        if (!$this->adherents->contains($adherent)) {
            $this->adherents[] = $adherent;
            $adherent->setCompany($this);
        }

        return $this;
    }

    public function removeAdherent(Adherent $adherent): self
    {
        if ($this->adherents->contains($adherent)) {
            $this->adherents->removeElement($adherent);
            // set the owning side to null (unless already changed)
            if ($adherent->getCompany() === $this) {
                $adherent->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Syndicat[]
     */
    public function getSyndicats(): Collection
    {
        return $this->syndicats;
    }

    public function addSyndicat(Syndicat $syndicat): self
    {
        if (!$this->syndicats->contains($syndicat)) {
            $this->syndicats[] = $syndicat;
            $syndicat->setCompany($this);
        }

        return $this;
    }

    public function removeSyndicat(Syndicat $syndicat): self
    {
        if ($this->syndicats->contains($syndicat)) {
            $this->syndicats->removeElement($syndicat);
            // set the owning side to null (unless already changed)
            if ($syndicat->getCompany() === $this) {
                $syndicat->setCompany(null);
            }
        }

        return $this;
    }

}
