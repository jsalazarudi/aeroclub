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

    public function __construct()
    {
        $this->cuentaCorrientes = new ArrayCollection();
        $this->reservasHangar = new ArrayCollection();
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
}
