<?php

namespace App\Entity;

use App\Repository\PilotoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PilotoRepository::class)]
class Piloto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\Type("\DateTimeInterface")]
    #[Assert\NotBlank()]
    private ?\DateTimeInterface $fecha_vencimiento_licencia_medica = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $tipo_licencia = null;

    #[ORM\OneToOne(targetEntity: Usuario::class,mappedBy: 'piloto', cascade: ['persist', 'remove'])]
    #[Assert\Type(type: Usuario::class)]
    #[Assert\Valid]
    private ?Usuario $usuario = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTipoLicencia(): ?string
    {
        return $this->tipo_licencia;
    }

    public function setTipoLicencia(string $tipo_licencia): self
    {
        $this->tipo_licencia = $tipo_licencia;

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
            $this->usuario->setPiloto(null);
        }

        // set the owning side of the relation if necessary
        if ($usuario !== null && $usuario->getPiloto() !== $this) {
            $usuario->setPiloto($this);
        }

        $this->usuario = $usuario;

        return $this;
    }
}
