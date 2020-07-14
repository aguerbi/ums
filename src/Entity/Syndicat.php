<?php

namespace App\Entity;

use App\Repository\SyndicatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=SyndicatRepository::class)
 * @UniqueEntity("name")
 */
class Syndicat {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="syndicats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $company;

    /**
     * @ORM\ManyToMany(targetEntity=Adherent::class, inversedBy="syndicats")
     */
    private $memberSyndicat;

    public function __construct() {
        $this->memberSyndicat = new ArrayCollection();
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

    public function getCompany(): ?Company {
        return $this->company;
    }

    public function setCompany(?Company $company): self {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection|Adherent[]
     */
    public function getMemberSyndicat(): Collection {
        return $this->memberSyndicat;
    }

    public function addMemberSyndicat(Adherent $memberSyndicat): self {
        if (!$this->memberSyndicat->contains($memberSyndicat)) {
            $this->memberSyndicat[] = $memberSyndicat;
        }

        return $this;
    }

    public function removeMemberSyndicat(Adherent $memberSyndicat): self {
        if ($this->memberSyndicat->contains($memberSyndicat)) {
            $this->memberSyndicat->removeElement($memberSyndicat);
        }

        return $this;
    }

    public function __toString() {
        return $this->name;
    }

}
