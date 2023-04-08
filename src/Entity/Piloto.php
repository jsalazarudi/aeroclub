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

    #[ORM\OneToMany(mappedBy: 'piloto_id', targetEntity: Vuelo::class)]
    private Collection $vuelos;

    #[ORM\OneToMany(mappedBy: 'piloto_id', targetEntity: Reserva::class)]
    private Collection $reservas;

    #[ORM\OneToMany(mappedBy: 'piloto_id', targetEntity: Abono::class)]
    private Collection $abonos;

    #[ORM\OneToMany(mappedBy: 'piloto_id', targetEntity: Venta::class)]
    private Collection $ventas;

    #[ORM\OneToOne(targetEntity: Usuario::class,mappedBy: 'piloto', cascade: ['persist', 'remove'])]
    #[Assert\Type(type: Usuario::class)]
    #[Assert\Valid]
    private ?Usuario $usuario = null;

    public function __construct()
    {
        $this->vuelos = new ArrayCollection();
        $this->reservas = new ArrayCollection();
        $this->abonos = new ArrayCollection();
        $this->ventas = new ArrayCollection();
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

    /**
     * @return Collection<int, Vuelo>
     */
    public function getVuelos(): Collection
    {
        return $this->vuelos;
    }

    public function addVuelo(Vuelo $vuelo): self
    {
        if (!$this->vuelos->contains($vuelo)) {
            $this->vuelos->add($vuelo);
            $vuelo->setPilotoId($this);
        }

        return $this;
    }

    public function removeVuelo(Vuelo $vuelo): self
    {
        if ($this->vuelos->removeElement($vuelo)) {
            // set the owning side to null (unless already changed)
            if ($vuelo->getPilotoId() === $this) {
                $vuelo->setPilotoId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reserva>
     */
    public function getReservas(): Collection
    {
        return $this->reservas;
    }

    public function addReserva(Reserva $reserva): self
    {
        if (!$this->reservas->contains($reserva)) {
            $this->reservas->add($reserva);
            $reserva->setPilotoId($this);
        }

        return $this;
    }

    public function removeReserva(Reserva $reserva): self
    {
        if ($this->reservas->removeElement($reserva)) {
            // set the owning side to null (unless already changed)
            if ($reserva->getPilotoId() === $this) {
                $reserva->setPilotoId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Abono>
     */
    public function getAbonos(): Collection
    {
        return $this->abonos;
    }

    public function addAbono(Abono $abono): self
    {
        if (!$this->abonos->contains($abono)) {
            $this->abonos->add($abono);
            $abono->setPilotoId($this);
        }

        return $this;
    }

    public function removeAbono(Abono $abono): self
    {
        if ($this->abonos->removeElement($abono)) {
            // set the owning side to null (unless already changed)
            if ($abono->getPilotoId() === $this) {
                $abono->setPilotoId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Venta>
     */
    public function getVentas(): Collection
    {
        return $this->ventas;
    }

    public function addVenta(Venta $venta): self
    {
        if (!$this->ventas->contains($venta)) {
            $this->ventas->add($venta);
            $venta->setPilotoId($this);
        }

        return $this;
    }

    public function removeVenta(Venta $venta): self
    {
        if ($this->ventas->removeElement($venta)) {
            // set the owning side to null (unless already changed)
            if ($venta->getPilotoId() === $this) {
                $venta->setPilotoId(null);
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
