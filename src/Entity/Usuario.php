<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
#[UniqueEntity('email')]
#[UniqueEntity('dni')]
class Usuario implements UserInterface,PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    #[Assert\Regex('/\d/')]
    private ?string $dni = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    private ?string $apellido = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Email()]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Regex('/\d/')]
    private ?string $telefono = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    private ?string $domicilio = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    private ?string $ciudad = null;

    #[ORM\Column]
    private ?bool $activo = null;

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    private ?string $password = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\OneToOne(targetEntity: Tesorero::class,inversedBy: 'usuario', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'tesorero_id',referencedColumnName: 'id')]
    private ?Tesorero $tesorero = null;

    #[ORM\OneToOne(targetEntity: Alumno::class,inversedBy: 'usuario', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'alumno_id',referencedColumnName: 'id')]
    private ?Alumno $alumno = null;

    #[ORM\OneToOne(targetEntity: Socio::class,inversedBy: 'usuario', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'socio_id',referencedColumnName: 'id')]
    private ?Socio $socio = null;

    #[ORM\OneToOne(targetEntity: Instructor::class,inversedBy: 'usuario', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'instructor_id',referencedColumnName: 'id')]
    private ?Instructor $instructor = null;

    #[ORM\OneToOne(targetEntity: Piloto::class,inversedBy: 'usuario', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'piloto_id',referencedColumnName: 'id')]
    private ?Piloto $piloto = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(string $dni): self
    {
        $this->dni = $dni;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): self
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getDomicilio(): ?string
    {
        return $this->domicilio;
    }

    public function setDomicilio(string $domicilio): self
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    public function getCiudad(): ?string
    {
        return $this->ciudad;
    }

    public function setCiudad(string $ciudad): self
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    public function isActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): self
    {
        $this->activo = $activo;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials()
    {

    }

    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    public function getTesorero(): ?Tesorero
    {
        return $this->tesorero;
    }

    public function setTesorero(?Tesorero $tesorero): self
    {
        $this->tesorero = $tesorero;

        return $this;
    }

    public function getAlumno(): ?Alumno
    {
        return $this->alumno;
    }

    public function setAlumno(?Alumno $alumno): self
    {
        $this->alumno = $alumno;

        return $this;
    }

    public function getSocio(): ?Socio
    {
        return $this->socio;
    }

    public function setSocio(?Socio $socio): self
    {
        $this->socio = $socio;

        return $this;
    }

    public function getInstructor(): ?Instructor
    {
        return $this->instructor;
    }

    public function setInstructor(?Instructor $instructor): self
    {
        $this->instructor = $instructor;

        return $this;
    }

    public function getPiloto(): ?Piloto
    {
        return $this->piloto;
    }

    public function setPiloto(?Piloto $piloto): self
    {
        $this->piloto = $piloto;

        return $this;
    }
}
