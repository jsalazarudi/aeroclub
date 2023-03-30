<?php

namespace App\Entity;

use App\Repository\AbonoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

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
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column]
    private ?bool $aprobado = null;

    #[ORM\ManyToOne(inversedBy: 'abonos')]
    private ?Tesorero $tesorero_id = null;

    #[ORM\ManyToOne(inversedBy: 'abonos')]
    private ?Socio $socio_id = null;

    #[ORM\ManyToOne(inversedBy: 'abonos')]
    private ?Piloto $piloto_id = null;

    #[ORM\OneToMany(mappedBy: 'abono_id', targetEntity: CuentaCorriente::class)]
    private Collection $cuentaCorrientes;

    public function __construct()
    {
        $this->cuentaCorrientes = new ArrayCollection();
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

    public function getTesoreroId(): ?Tesorero
    {
        return $this->tesorero_id;
    }

    public function setTesoreroId(?Tesorero $tesorero_id): self
    {
        $this->tesorero_id = $tesorero_id;

        return $this;
    }

    public function getSocioId(): ?Socio
    {
        return $this->socio_id;
    }

    public function setSocioId(?Socio $socio_id): self
    {
        $this->socio_id = $socio_id;

        return $this;
    }

    public function getPilotoId(): ?Piloto
    {
        return $this->piloto_id;
    }

    public function setPilotoId(?Piloto $piloto_id): self
    {
        $this->piloto_id = $piloto_id;

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
}
