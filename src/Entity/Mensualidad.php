<?php

namespace App\Entity;

use App\Repository\MensualidadRepository;
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

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank()]
    #[Assert\Type("\DateTimeInterface")]

    private ?\DateTimeInterface $hasta = null;

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

    public function getHasta(): ?\DateTimeInterface
    {
        return $this->hasta;
    }

    public function setHasta(\DateTimeInterface $hasta): self
    {
        $this->hasta = $hasta;

        return $this;
    }
}
