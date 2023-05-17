<?php

namespace App\Entity;

use App\Repository\MensualidadRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MensualidadRepository::class)]
class Mensualidad
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'mensualidades')]
    #[Assert\NotBlank()]
    #[ORM\JoinColumn(nullable: false)]
    private ?Socio $socio = null;

    #[ORM\ManyToOne(inversedBy: 'mensualidades')]
    #[Assert\NotBlank()]
    #[ORM\JoinColumn(nullable: false)]
    private ?Servicio $servicio = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank()]
    #[Assert\Type("\DateTimeInterface")]
    private ?\DateTimeInterface $fecha_inicio = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank()]
    #[Assert\Type("\DateTimeInterface")]
    private ?\DateTimeInterface $fecha_fin = null;

    #[ORM\OneToMany(mappedBy: 'mensualidad', targetEntity: PagoMensualidad::class, cascade: ['persist','remove'], orphanRemoval: true)]
    private Collection $pagoMensualidads;

    public function __construct()
    {
        $this->pagoMensualidads = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getServicio(): ?Servicio
    {
        return $this->servicio;
    }

    public function setServicio(?Servicio $servicio): self
    {
        $this->servicio = $servicio;

        return $this;
    }

    public function getFechaInicio(): ?\DateTimeInterface
    {
        return $this->fecha_inicio;
    }

    public function setFechaInicio(\DateTimeInterface $fecha_inicio): self
    {
        $this->fecha_inicio = $fecha_inicio;

        return $this;
    }

    public function getFechaFin(): ?\DateTimeInterface
    {
        return $this->fecha_fin;
    }

    public function setFechaFin(\DateTimeInterface $fecha_fin): self
    {
        $this->fecha_fin = $fecha_fin;

        return $this;
    }

    /**
     * @return Collection<int, PagoMensualidad>
     */
    public function getPagoMensualidads(): Collection
    {
        return $this->pagoMensualidads;
    }

    public function addPagoMensualidad(PagoMensualidad $pagoMensualidad): self
    {
        if (!$this->pagoMensualidads->contains($pagoMensualidad)) {
            $this->pagoMensualidads->add($pagoMensualidad);
            $pagoMensualidad->setMensualidad($this);
        }

        return $this;
    }

    public function removePagoMensualidad(PagoMensualidad $pagoMensualidad): self
    {
        if ($this->pagoMensualidads->removeElement($pagoMensualidad)) {
            // set the owning side to null (unless already changed)
            if ($pagoMensualidad->getMensualidad() === $this) {
                $pagoMensualidad->setMensualidad(null);
            }
        }

        return $this;
    }

    #[ORM\PreRemove()]
    public function validarPagoMensual()
    {
        dd("holi");
    }
}
