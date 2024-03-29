<?php

namespace App\Entity;

use App\Repository\SocioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SocioRepository::class)]
#[UniqueEntity('numero_socio')]
class Socio
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
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    private ?string $tipo_licencia = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    private ?string $numero_socio = null;

    #[ORM\OneToOne(mappedBy: 'socio', cascade: ['persist', 'remove'])]
    #[Assert\Type(type: Usuario::class)]
    #[Assert\Valid]
    private ?Usuario $usuario = null;

    #[ORM\OneToMany(mappedBy: 'socio', targetEntity: Mensualidad::class, cascade: ['persist'] , orphanRemoval: true)]
    private Collection $mensualidades;
   public function __construct()
    {
        $this->mensualidades = new ArrayCollection();
    }

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

    public function getNumeroSocio(): ?string
    {
        return $this->numero_socio;
    }

    public function setNumeroSocio(string $numero_socio): self
    {
        $this->numero_socio = $numero_socio;

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
            $this->usuario->setSocio(null);
        }

        // set the owning side of the relation if necessary
        if ($usuario !== null && $usuario->getSocio() !== $this) {
            $usuario->setSocio($this);
        }

        $this->usuario = $usuario;

        return $this;
    }

    /**
     * @return Collection<int, Mensualidad>
     */
    public function getMensualidades(): Collection
    {
        return $this->mensualidades;
    }

    public function addMensualidade(Mensualidad $mensualidad): self
    {
        if (!$this->mensualidades->contains($mensualidad)) {
            $this->mensualidades->add($mensualidad);
            $mensualidad->setSocio($this);
        }

        return $this;
    }

    public function removeMensualidade(Mensualidad $mensualidad): self
    {
        if ($this->mensualidades->removeElement($mensualidad)) {
            // set the owning side to null (unless already changed)
            if ($mensualidad->getSocio() === $this) {
                $mensualidad->setSocio(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getUsuario()->getNombre(). ' '.$this->getUsuario()->getApellido();
    }


}
