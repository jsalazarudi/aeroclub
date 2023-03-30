<?php

namespace App\Entity;

use App\Repository\AlumnoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlumnoRepository::class)]
class Alumno
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $dni = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $apellido = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $telefono = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $domicilio = null;

    #[ORM\Column(length: 255)]
    private ?string $ciudad = null;

    #[ORM\Column]
    private ?bool $habilitado_volar = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_vencimiento_licencia_medica = null;

    #[ORM\OneToOne(mappedBy: 'alumno_id', cascade: ['persist', 'remove'])]
    private ?Curso $curso = null;

    #[ORM\ManyToOne(inversedBy: 'alumnos')]
    private ?Instructor $habilitado_por_instructor_id = null;

    #[ORM\ManyToOne(inversedBy: 'alumnos')]
    private ?Tesorero $habilitado_por_tesorero_id = null;

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

    public function getCurso(): ?Curso
    {
        return $this->curso;
    }

    public function setCurso(Curso $curso): self
    {
        // set the owning side of the relation if necessary
        if ($curso->getAlumnoId() !== $this) {
            $curso->setAlumnoId($this);
        }

        $this->curso = $curso;

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
}
