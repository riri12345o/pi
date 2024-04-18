<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\UserRepository;

/**
 * User1
 *
 * @ORM\Table(name="user1")
 * @ORM\Entity
 */
#[ORM\Entity(repositoryClass:UserRepository::class)]
#[ORM\Table(name:"user1")]
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id", type: "integer", nullable: false)]
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    #[ORM\Column(name: "email", type: "string", length:255, nullable: false)]
    #[Assert\NotBlank(groups: ["login"], message: "Please enter your email")]
    #[Assert\Email(groups: ["login"], message: "The email '{{ value }}' is not a valid email.")]
     private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="roles", type="string", length=255, nullable=false)
     */
    #[ORM\Column(name: "roles", type: "string", length:255, nullable: false)]
    #[Assert\NotBlank]
    private $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    #[ORM\Column(name: "password", type: "string", length:255, nullable: false)]
    #[Assert\NotBlank(groups: ["login"], message: "Please enter your email")]
    #[Assert\Regex(
        pattern: "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).{8,}$/",
        groups:["login"],
        message: "The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character."
    )]
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    #[ORM\Column(name: "nom", type: "string", length:255, nullable: false)]
    #[Assert\NotBlank]
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=false)
     */
    #[ORM\Column(name: "prenom", type: "string", length:255, nullable: false)]
    #[Assert\NotBlank]
    private $prenom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=true)
     */
    #[ORM\Column(name: "photo", type: "string", length:255, nullable: true)]
    private $photo;

    /**
     * @var int
     *
     * @ORM\Column(name="cin", type="integer", nullable=false)
     */
    #[ORM\Column(name: "cin", type: "integer", nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 8, max: 8)]
    private $cin;

    /**
     * @var string|null
     *
     * @ORM\Column(name="region", type="string", length=255, nullable=true)
     */
    #[ORM\Column(name: "region", type: "string", length:255, nullable: true)]
    #[Assert\NotBlank]
    private $region;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=true)
     */
    #[ORM\Column(name: "ville", type: "string", length:255, nullable: true)]
    #[Assert\NotBlank]
    private $ville;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
     */
    #[ORM\Column(name: "adresse", type: "string", length:255, nullable: true)]
    #[Assert\NotBlank]
    private $adresse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="isactive", type="string", length=255, nullable=true)
     */
    #[ORM\Column(name: "isactive", type: "string", length:255, nullable: true)]
    #[Assert\NotBlank]
    private $isactive;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="is_verified", type="boolean", nullable=true)
     */
    #[ORM\Column(name: "is_verified", type: "boolean", nullable: true)]
    #[Assert\NotBlank]
    private $isVerified;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getRoles(): ?string
    {
        return $this->roles;
    }

    public function setRoles(string $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getCin(): ?int
    {
        return $this->cin;
    }

    public function setCin(int $cin): static
    {
        $this->cin = $cin;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): static
    {
        $this->region = $region;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getIsactive(): ?string
    {
        return $this->isactive;
    }

    public function setIsactive(?string $isactive): static
    {
        $this->isactive = $isactive;

        return $this;
    }

    public function isIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(?bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }


}
