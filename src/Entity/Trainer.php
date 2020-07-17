<?php

namespace App\Entity;

use App\Repository\TrainerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TrainerRepository::class)
 */
class Trainer {

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
    private $mobile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $specialty;

    /**
     * @ORM\ManyToMany(targetEntity=Training::class, mappedBy="trainer")
     */
    private $trainings;

    public function __construct() {
        $this->trainings = new ArrayCollection();
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

    public function getMobile(): ?string {
        return $this->mobile;
    }

    public function setMobile(string $mobile): self {
        $this->mobile = $mobile;

        return $this;
    }

    public function getSpecialty(): ?string {
        return $this->specialty;
    }

    public function setSpecialty(string $specialty): self {
        $this->specialty = $specialty;

        return $this;
    }

    public function fullName() {
        return $this->firstName . " " . $this->lastName;
    }

    /**
     * @return Collection|Training[]
     */
    public function getTrainings(): Collection {
        return $this->trainings;
    }

    public function addTraining(Training $training): self {
        if (!$this->trainings->contains($training)) {
            $this->trainings[] = $training;
            $training->addTrainer($this);
        }

        return $this;
    }

    public function removeTraining(Training $training): self {
        if ($this->trainings->contains($training)) {
            $this->trainings->removeElement($training);
            $training->removeTrainer($this);
        }

        return $this;
    }

    public function __toString() {
        return $this->fullName();
    }

}
