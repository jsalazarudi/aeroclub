<?php

namespace App\Entity;

use App\Repository\HangarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HangarRepository::class)]
class Hangar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descripcion = null;

    #[ORM\OneToMany(mappedBy: 'hangar_id', targetEntity: ReservaHangar::class)]
    private Collection $reservaHangars;

    public function __construct()
    {
        $this->reservaHangars = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return Collection<int, ReservaHangar>
     */
    public function getReservaHangars(): Collection
    {
        return $this->reservaHangars;
    }

    public function addReservaHangar(ReservaHangar $reservaHangar): self
    {
        if (!$this->reservaHangars->contains($reservaHangar)) {
            $this->reservaHangars->add($reservaHangar);
            $reservaHangar->setHangarId($this);
        }

        return $this;
    }

    public function removeReservaHangar(ReservaHangar $reservaHangar): self
    {
        if ($this->reservaHangars->removeElement($reservaHangar)) {
            // set the owning side to null (unless already changed)
            if ($reservaHangar->getHangarId() === $this) {
                $reservaHangar->setHangarId(null);
            }
        }

        return $this;
    }
}
