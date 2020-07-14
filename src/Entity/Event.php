<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 * @Vich\Uploadable
 */
class Event {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $document;

    /**
     * @Vich\UploadableField(mapping="event_document", fileNameProperty="document")
     * @var File
     */
    private $documentFile;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $company;

    public function __construct() {
        $this->updatedAt = new \DateTime("now");
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getTitle(): ?string {
        return $this->title;
    }

    public function setTitle(string $title): self {
        $this->title = $title;

        return $this;
    }

    public function setDocumentFile(File $document = null) {
        $this->documentFile = $document;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($document) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getDocumentFile() {
        return $this->documentFile;
    }

    public function getDocument(): ?string {
        return $this->document;
    }

    public function setDocument(string $document): self {
        $this->document = $document;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self {
        $this->updatedAt = $updatedAt;

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

}
