<?php

namespace App\Entity;

use App\Repository\VueloMotorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VueloMotorRepository::class)]
class VueloMotor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    #[Assert\Type("integer")]
    private ?int $aterrizajes = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Type("string")]
    private ?string $pista_despegue = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Type("string")]
    private ?string $pista_aterrizaje = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    #[Assert\Type("integer")]
    private ?int $horometro_despegue = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    #[Assert\Type("integer")]
    private ?int $horometro_aterrizaje = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Type("string")]
    private ?string $tipo_vuelo = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vuelo $vuelo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAterrizajes(): ?int
    {
        return $this->aterrizajes;
    }

    public function setAterrizajes(int $aterrizajes): self
    {
        $this->aterrizajes = $aterrizajes;

        return $this;
    }

    public function getPistaDespegue(): ?string
    {
        return $this->pista_despegue;
    }

    public function setPistaDespegue(string $pista_despegue): self
    {
        $this->pista_despegue = $pista_despegue;

        return $this;
    }

    public function getPistaAterrizaje(): ?string
    {
        return $this->pista_aterrizaje;
    }

    public function setPistaAterrizaje(string $pista_aterrizaje): self
    {
        $this->pista_aterrizaje = $pista_aterrizaje;

        return $this;
    }

    public function getHorometroDespegue(): ?int
    {
        return $this->horometro_despegue;
    }

    public function setHorometroDespegue(int $horometro_despegue): self
    {
        $this->horometro_despegue = $horometro_despegue;

        return $this;
    }

    public function getHorometroAterrizaje(): ?int
    {
        return $this->horometro_aterrizaje;
    }

    public function setHorometroAterrizaje(int $horometro_aterrizaje): self
    {
        $this->horometro_aterrizaje = $horometro_aterrizaje;

        return $this;
    }

    public function getTipoVuelo(): ?string
    {
        return $this->tipo_vuelo;
    }

    public function setTipoVuelo(string $tipo_vuelo): self
    {
        $this->tipo_vuelo = $tipo_vuelo;

        return $this;
    }

    public function getVuelo(): ?Vuelo
    {
        return $this->vuelo;
    }

    public function setVuelo(Vuelo $vuelo): self
    {
        $this->vuelo = $vuelo;

        return $this;
    }
}
