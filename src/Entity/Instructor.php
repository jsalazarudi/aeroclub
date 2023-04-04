<?php

namespace App\Entity;

use App\Repository\InstructorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InstructorRepository::class)]
class Instructor implements UserInterface, PasswordAuthenticatedUserInterface
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

    #[ORM\OneToMany(mappedBy: 'habilitado_por_instructor_id', targetEntity: Alumno::class)]
    private Collection $alumnos;

    #[ORM\OneToMany(mappedBy: 'instructor_id', targetEntity: InstructorVuelo::class)]
    private Collection $instructorVuelos;

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    private $password;

    #[ORM\Column]
    private ?bool $activo = null;

    public function __construct()
    {
        $this->alumnos = new ArrayCollection();
        $this->instructorVuelos = new ArrayCollection();
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

    /**
     * @return Collection<int, Alumno>
     */
    public function getAlumnos(): Collection
    {
        return $this->alumnos;
    }

    public function addAlumno(Alumno $alumno): self
    {
        if (!$this->alumnos->contains($alumno)) {
            $this->alumnos->add($alumno);
            $alumno->setHabilitadoPorInstructorId($this);
        }

        return $this;
    }

    public function removeAlumno(Alumno $alumno): self
    {
        if ($this->alumnos->removeElement($alumno)) {
            // set the owning side to null (unless already changed)
            if ($alumno->getHabilitadoPorInstructorId() === $this) {
                $alumno->setHabilitadoPorInstructorId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, InstructorVuelo>
     */
    public function getInstructorVuelos(): Collection
    {
        return $this->instructorVuelos;
    }

    public function addInstructorVuelo(InstructorVuelo $instructorVuelo): self
    {
        if (!$this->instructorVuelos->contains($instructorVuelo)) {
            $this->instructorVuelos->add($instructorVuelo);
            $instructorVuelo->setInstructorId($this);
        }

        return $this;
    }

    public function removeInstructorVuelo(InstructorVuelo $instructorVuelo): self
    {
        if ($this->instructorVuelos->removeElement($instructorVuelo)) {
            // set the owning side to null (unless already changed)
            if ($instructorVuelo->getInstructorId() === $this) {
                $instructorVuelo->setInstructorId(null);
            }
        }

        return $this;
    }

    public function getRoles(): array
    {
        return ['ROL_INSTRUCTOR'];
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

    public function __toString(): string
    {
        return $this->nombre . ' ' . $this->apellido;
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


}
