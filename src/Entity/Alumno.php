<?php

namespace App\Entity;

use App\Repository\AlumnoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AlumnoRepository::class)]
class Alumno
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
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

    #[ORM\OneToMany(mappedBy: 'alumno', targetEntity: Curso::class)]
    private Collection $curso;

    #[ORM\OneToOne(targetEntity: Usuario::class,mappedBy: 'alumno', cascade: ['persist', 'remove'])]
    #[Assert\Type(type: Usuario::class)]
    #[Assert\Valid]
    private ?Usuario $usuario = null;

    public function __construct()
    {
        $this->curso = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        // unset the owning side of the relation if necessary
        if ($usuario === null && $this->usuario !== null) {
            $this->usuario->setAlumno(null);
        }

        // set the owning side of the relation if necessary
        if ($usuario !== null && $usuario->getAlumno() !== $this) {
            $usuario->setAlumno($this);
        }

        $this->usuario = $usuario;

        return $this;
    }

    public function __toString(): string
    {
        return $this->nombre.' '.$this->apellido;
    }
}
