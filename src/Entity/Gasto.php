<?php

namespace App\Entity;

use App\Repository\GastoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GastoRepository::class)]
class Gasto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Ignore]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    #[Assert\Type('integer')]
    private ?int $valor = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    private ?string $descripcion = null;

    #[ORM\ManyToOne(inversedBy: 'gastos')]
    #[ORM\JoinColumn(nullable: false)]
    #[Ignore]
    private ?Tesorero $tesorero = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\Type("\DateTimeInterface")]
    #[Assert\NotBlank()]
    private ?\DateTimeInterface $fecha = null;

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

    public function getTesorero(): ?Tesorero
    {
        return $this->tesorero;
    }

    public function setTesorero(?Tesorero $tesorero): self
    {
        $this->tesorero = $tesorero;

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
}
