<?php

namespace App\Entity;

use App\Repository\AlumnoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AlumnoRepository::class)]
#[UniqueEntity('email')]
class Alumno implements UserInterface, PasswordAuthenticatedUserInterface
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
    private ?bool $habilitado_volar = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\Type("\DateTimeInterface")]
    #[Assert\NotBlank()]
    private ?\DateTimeInterface $fecha_vencimiento_licencia_medica = null;

    #[ORM\ManyToOne(inversedBy: 'alumnos')]
    private ?Instructor $habilitado_por_instructor_id = null;

    #[ORM\ManyToOne(inversedBy: 'alumnos')]
    private ?Tesorero $habilitado_por_tesorero_id = null;

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    private $password;

    #[ORM\Column]
    private ?bool $activo = null;

    #[ORM\OneToMany(mappedBy: 'alumno', targetEntity: Curso::class)]
    private Collection $curso;

    public function __construct()
    {
        $this->curso = new ArrayCollection();
    }

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

    public function isHabilitadoVolar(): ?bool
    {
        return $this->habilitado_volar;
    }

    public function setHabilitadoVolar(bool $habilitado_volar): self
    {
        $this->habilitado_volar = $habilitado_volar;

        return $this;
    }

    public function getFechaVencimientoLicenciaMedica(): ?\DateTimeInterface
    {
        return $this->fecha_vencimiento_licencia_medica;
    }

    public function setFechaVencimientoLicenciaMedica(\DateTimeInterface $fecha_vencimiento_licencia_medica): self
    {
        $this->fecha_vencimiento_licencia_medica = $fecha_vencimiento_licencia_medica;

        return $this;
    }

    public function getHabilitadoPorInstructorId(): ?Instructor
    {
        return $this->habilitado_por_instructor_id;
    }

    public function setHabilitadoPorInstructorId(?Instructor $habilitado_por_instructor_id): self
    {
        $this->habilitado_por_instructor_id = $habilitado_por_instructor_id;

        return $this;
    }

    public function getHabilitadoPorTesoreroId(): ?Tesorero
    {
        return $this->habilitado_por_tesorero_id;
    }

    public function setHabilitadoPorTesoreroId(?Tesorero $habilitado_por_tesorero_id): self
    {
        $this->habilitado_por_tesorero_id = $habilitado_por_tesorero_id;

        return $this;
    }

    public function getRoles(): array
    {
        return ['ROL_ALUMNO'];
    }

    public function eraseCredentials()
    {

    }

    public function getUserIdentifier(): string
    {
        return (string)$this->email;
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

    public function isActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): self
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * @return Collection<int, Curso>
     */
    public function getCurso(): Collection
    {
        return $this->curso;
    }

    public function addCurso(Curso $curso): self
    {
        if (!$this->curso->contains($curso)) {
            $this->curso->add($curso);
            $curso->setAlumno($this);
        }

        return $this;
    }

    public function removeCurso(Curso $curso): self
    {
        if ($this->curso->removeElement($curso)) {
            // set the owning side to null (unless already changed)
            if ($curso->getAlumno() === $this) {
                $curso->setAlumno(null);
            }
        }

        return $this;
    }
}
