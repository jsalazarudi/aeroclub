<?php

namespace App\Entity;

use App\Repository\AlumnoRepository;
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

    #[ORM\OneToOne(mappedBy: 'alumno', targetEntity: Usuario::class, cascade: ['persist', 'remove'])]
    #[Assert\Type(type: Usuario::class)]
    #[Assert\Valid]
    private ?Usuario $usuario = null;

    #[ORM\ManyToOne(inversedBy: 'alumnos')]
    private ?Usuario $aprobado = null;

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
        return $this->getUsuario()->getNombre() . ' ' . $this->getUsuario()->getApellido();
    }

    public function getAprobado(): ?Usuario
    {
        return $this->aprobado;
    }

    public function setAprobado(?Usuario $aprobado): self
    {
        $this->aprobado = $aprobado;

        return $this;
    }
}
