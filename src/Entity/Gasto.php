<?php

namespace App\Entity;

use App\Repository\GastoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GastoRepository::class)]
class Gasto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $valor = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descripcion = null;

    #[ORM\ManyToOne(inversedBy: 'gastos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tesorero $tesorero_id = null;

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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

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
}
