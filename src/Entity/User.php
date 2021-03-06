<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="`user`")
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 */
class User implements UserInterface, \Serializable {

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string

     * @ORM\Column(type="string", unique=true)
     */
    private $username;

    /**
     * @var string

     * @ORM\Column(type="string", unique=true)
     */
    private $fullName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var array
     *
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled = true;

    /**
     * @var string le token qui servira lors de l'oubli de mot de passe
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $resetToken;

    public function __construct() {

    }

    public function getId(): int {
        return $this->id;
    }

    public function getUsername(): ?string {
        return $this->username;
    }

    public function setUsername(string $username): void {
        $this->username = $username;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getPassword(): ?string {
        return $this->password;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    /**
     * Retourne les rôles de l'user
     */
    public function getRoles(): array {
        $roles = $this->roles;

        // Afin d'être sûr qu'un user a toujours au moins 1 rôle
        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): void {
        $this->roles = $roles;
    }

    /**
     * Retour le salt qui a servi à coder le mot de passe
     *
     * {@inheritdoc}
     */
    public function getSalt(): ?string {
        // See "Do you need to use a Salt?" at https://symfony.com/doc/current/cookbook/security/entity_provider.html
        // we're using bcrypt in security.yml to encode the password, so
        // the salt value is built-in and you don't have to generate one

        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * {@inheritdoc}
     */
    public function eraseCredentials(): void {
        // Nous n'avons pas besoin de cette methode car nous n'utilions pas de plainPassword
        // Mais elle est obligatoire car comprise dans l'interface UserInterface
        // $this->plainPassword = null;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): string {
        return serialize([$this->id, $this->username, $this->password]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized): void {
        [$this->id, $this->username, $this->password] = unserialize($serialized, ['allowed_classes' => false]);
    }

    public function getFullName(): ?string {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self {
        $this->fullName = $fullName;

        return $this;
    }

    public function getEnabled(): ?bool {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return string
     */
    public function getResetToken(): string {
        return $this->resetToken;
    }

    /**
     * @param string $resetToken
     */
    public function setResetToken(?string $resetToken): void {
        $this->resetToken = $resetToken;
    }

}
