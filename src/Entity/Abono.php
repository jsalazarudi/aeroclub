<?php

namespace App\Entity;

use App\Repository\AbonoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AbonoRepository::class)]
class Abono
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $valor = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank()]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column]
    private ?bool $aprobado = null;

    #[ORM\ManyToOne(inversedBy: 'abonos')]
    private ?Tesorero $tesorero = null;

    #[ORM\ManyToOne(inversedBy: 'abonos')]
    private ?Socio $socio = null;

    #[ORM\ManyToOne(inversedBy: 'abonos')]
    private ?Piloto $piloto = null;

    #[ORM\OneToMany(mappedBy: 'abono_id', targetEntity: CuentaCorriente::class)]
    private Collection $cuentaCorrientes;

    #[ORM\ManyToOne(inversedBy: 'abonos')]
    private ?Alumno $alumno = null;

    #[ORM\OneToMany(mappedBy: 'abono', targetEntity: ReservaHangar::class)]
    private Collection $reservasHangar;

    #[ORM\OneToMany(mappedBy: 'abono', targetEntity: MovimientoCuentaVuelo::class)]
    private Collection $movimientoCuentaVuelos;

    #[ORM\OneToMany(mappedBy: 'abono', targetEntity: Venta::class)]
    private Collection $ventas;

    #[ORM\OneToMany(mappedBy: 'abono', targetEntity: PagoMensualidad::class)]
    private Collection $pagoMensualidads;

    public function __construct()
    {
        $this->cuentaCorrientes = new ArrayCollection();
        $this->reservasHangar = new ArrayCollection();
        $this->movimientoCuentaVuelos = new ArrayCollection();
        $this->ventas = new ArrayCollection();
        $this->pagoMensualidads = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValor(): ?int
    {
        return $this->valor;
    }

    public function setValor(int $valor): self
    {
        $this->valor = $valor;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function isAprobado(): ?bool
    {
        return $this->aprobado;
    }

    public function setAprobado(bool $aprobado): self
    {
        $this->aprobado = $aprobado;

        return $this;
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

    public function getSocio(): ?Socio
    {
        return $this->socio;
    }

    public function setSocio(?Socio $socio): self
    {
        $this->socio = $socio;

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

    /**
     * @return Collection<int, CuentaCorriente>
     */
    public function getCuentaCorrientes(): Collection
    {
        return $this->cuentaCorrientes;
    }

    public function addCuentaCorriente(CuentaCorriente $cuentaCorriente): self
    {
        if (!$this->cuentaCorrientes->contains($cuentaCorriente)) {
            $this->cuentaCorrientes->add($cuentaCorriente);
            $cuentaCorriente->setAbonoId($this);
        }

        return $this;
    }

    public function removeCuentaCorriente(CuentaCorriente $cuentaCorriente): self
    {
        if ($this->cuentaCorrientes->removeElement($cuentaCorriente)) {
            // set the owning side to null (unless already changed)
            if ($cuentaCorriente->getAbonoId() === $this) {
                $cuentaCorriente->setAbonoId(null);
            }
        }

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

    /**
     * @return Collection<int, ReservaHangar>
     */
    public function getReservasHangar(): Collection
    {
        return $this->reservasHangar;
    }

    public function addReservasHangar(ReservaHangar $reservasHangar): self
    {
        if (!$this->reservasHangar->contains($reservasHangar)) {
            $this->reservasHangar->add($reservasHangar);
            $reservasHangar->setAbono($this);
        }

        return $this;
    }

    public function removeReservasHangar(ReservaHangar $reservasHangar): self
    {
        if ($this->reservasHangar->removeElement($reservasHangar)) {
            // set the owning side to null (unless already changed)
            if ($reservasHangar->getAbono() === $this) {
                $reservasHangar->setAbono(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MovimientoCuentaVuelo>
     */
    public function getMovimientoCuentaVuelos(): Collection
    {
        return $this->movimientoCuentaVuelos;
    }

    public function addMovimientoCuentaVuelo(MovimientoCuentaVuelo $movimientoCuentaVuelo): self
    {
        if (!$this->movimientoCuentaVuelos->contains($movimientoCuentaVuelo)) {
            $this->movimientoCuentaVuelos->add($movimientoCuentaVuelo);
            $movimientoCuentaVuelo->setAbono($this);
        }

        return $this;
    }

    public function removeMovimientoCuentaVuelo(MovimientoCuentaVuelo $movimientoCuentaVuelo): self
    {
        if ($this->movimientoCuentaVuelos->removeElement($movimientoCuentaVuelo)) {
            // set the owning side to null (unless already changed)
            if ($movimientoCuentaVuelo->getAbono() === $this) {
                $movimientoCuentaVuelo->setAbono(null);
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
            $venta->setAbono($this);
        }

        return $this;
    }

    public function removeVenta(Venta $venta): self
    {
        if ($this->ventas->removeElement($venta)) {
            // set the owning side to null (unless already changed)
            if ($venta->getAbono() === $this) {
                $venta->setAbono(null);
            }
        }

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
            $pagoMensualidad->setAbono($this);
        }

        return $this;
    }

    public function removePagoMensualidad(PagoMensualidad $pagoMensualidad): self
    {
        if ($this->pagoMensualidads->removeElement($pagoMensualidad)) {
            // set the owning side to null (unless already changed)
            if ($pagoMensualidad->getAbono() === $this) {
                $pagoMensualidad->setAbono(null);
            }
        }

        return $this;
    }
}
