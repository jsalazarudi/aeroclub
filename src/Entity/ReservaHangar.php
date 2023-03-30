<?php

namespace App\Entity;

use App\Repository\ReservaHangarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservaHangarRepository::class)]
class ReservaHangar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $unidades_gastadas = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Reserva $reserva_id = null;

    #[ORM\ManyToOne(inversedBy: 'reservaHangars')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Hangar $hangar_id = null;

    #[ORM\OneToMany(mappedBy: 'reserva_hangar_id', targetEntity: CuentaCorriente::class)]
    private Collection $cuentaCorrientes;

    public function __construct()
    {
        $this->cuentaCorrientes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUnidadesGastadas(): ?int
    {
        return $this->unidades_gastadas;
    }

    public function setUnidadesGastadas(int $unidades_gastadas): self
    {
        $this->unidades_gastadas = $unidades_gastadas;

        return $this;
    }

    public function getReservaId(): ?Reserva
    {
        return $this->reserva_id;
    }

    public function setReservaId(Reserva $reserva_id): self
    {
        $this->reserva_id = $reserva_id;

        return $this;
    }

    public function getHangarId(): ?Hangar
    {
        return $this->hangar_id;
    }

    public function setHangarId(?Hangar $hangar_id): self
    {
        $this->hangar_id = $hangar_id;

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
            $cuentaCorriente->setReservaHangarId($this);
        }

        return $this;
    }

    public function removeCuentaCorriente(CuentaCorriente $cuentaCorriente): self
    {
        if ($this->cuentaCorrientes->removeElement($cuentaCorriente)) {
            // set the owning side to null (unless already changed)
            if ($cuentaCorriente->getReservaHangarId() === $this) {
                $cuentaCorriente->setReservaHangarId(null);
            }
        }

        return $this;
    }
}
