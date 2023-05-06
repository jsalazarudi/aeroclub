<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
#[UniqueEntity('email')]
#[UniqueEntity('dni')]
class Usuario implements UserInterface,PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    #[Assert\Regex('/\d/')]
    private ?string $dni = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    private ?string $apellido = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Email()]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Regex('/\d/')]
    private ?string $telefono = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    private ?string $domicilio = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    private ?string $ciudad = null;


    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    private ?string $password = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\OneToOne(inversedBy: 'usuario', targetEntity: Tesorero::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'tesorero_id',referencedColumnName: 'id')]
    private ?Tesorero $tesorero = null;

    #[ORM\OneToOne(inversedBy: 'usuario', targetEntity: Alumno::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'alumno_id',referencedColumnName: 'id')]
    private ?Alumno $alumno = null;

    #[ORM\OneToOne(inversedBy: 'usuario', targetEntity: Socio::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'socio_id',referencedColumnName: 'id')]
    private ?Socio $socio = null;

    #[ORM\OneToOne(inversedBy: 'usuario', targetEntity: Instructor::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'instructor_id',referencedColumnName: 'id')]
    private ?Instructor $instructor = null;

    #[ORM\OneToOne(inversedBy: 'usuario', targetEntity: Piloto::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'piloto_id',referencedColumnName: 'id')]
    private ?Piloto $piloto = null;

    #[ORM\OneToMany(mappedBy: 'paga', targetEntity: Abono::class)]
    private Collection $abonos;

    #[ORM\OneToMany(mappedBy: 'aprueba', targetEntity: Abono::class)]
    private Collection $abonos_aprobados;

    #[ORM\OneToMany(mappedBy: 'usuario', targetEntity: Reserva::class)]
    private Collection $reservas;

    #[ORM\OneToMany(mappedBy: 'aprobada', targetEntity: Venta::class)]
    private Collection $ventasAprobadas;

    #[ORM\OneToMany(mappedBy: 'realizada', targetEntity: Venta::class)]
    private Collection $ventas;

    #[ORM\OneToMany(mappedBy: 'aprobado', targetEntity: Alumno::class)]
    private Collection $alumnos;

    #[ORM\OneToMany(mappedBy: 'realizado', targetEntity: MovimientoStock::class)]
    private Collection $movimientoStocks;

    #[ORM\OneToMany(mappedBy: 'alumno', targetEntity: Curso::class)]
    private Collection $cursos;

    public function __construct()
    {
        $this->abonos = new ArrayCollection();
        $this->abonos_aprobados = new ArrayCollection();
        $this->reservas = new ArrayCollection();
        $this->ventasAprobadas = new ArrayCollection();
        $this->ventas = new ArrayCollection();
        $this->alumnos = new ArrayCollection();
        $this->movimientoStocks = new ArrayCollection();
        $this->cursos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(string $dni): self
    {
        $this->dni = $dni;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): self
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getDomicilio(): ?string
    {
        return $this->domicilio;
    }

    public function setDomicilio(string $domicilio): self
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    public function getCiudad(): ?string
    {
        return $this->ciudad;
    }

    public function setCiudad(string $ciudad): self
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials()
    {

    }

    public function getUserIdentifier(): string
    {
        return (string)$this->email;
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

    public function getAlumno(): ?Alumno
    {
        return $this->alumno;
    }

    public function setAlumno(?Alumno $alumno): self
    {
        $this->alumno = $alumno;

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

    public function getInstructor(): ?Instructor
    {
        return $this->instructor;
    }

    public function setInstructor(?Instructor $instructor): self
    {
        $this->instructor = $instructor;

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
            $abono->setPaga($this);
        }

        return $this;
    }

    public function removeAbono(Abono $abono): self
    {
        if ($this->abonos->removeElement($abono)) {
            // set the owning side to null (unless already changed)
            if ($abono->getPaga() === $this) {
                $abono->setPaga(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Abono>
     */
    public function getAbonosAprobados(): Collection
    {
        return $this->abonos_aprobados;
    }

    public function addAbonoAprobado(Abono $abono): self
    {
        if (!$this->abonos_aprobados->contains($abono)) {
            $this->abonos_aprobados->add($abono);
            $abono->setAprueba($this);
        }

        return $this;
    }

    public function removeAbonoAprobado(Abono $abono): self
    {
        if ($this->abonos_aprobados->removeElement($abono)) {
            // set the owning side to null (unless already changed)
            if ($abono->getAprueba() === $this) {
                $abono->setAprueba(null);
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
            $reserva->setUsuario($this);
        }

        return $this;
    }

    public function removeReserva(Reserva $reserva): self
    {
        if ($this->reservas->removeElement($reserva)) {
            // set the owning side to null (unless already changed)
            if ($reserva->getUsuario() === $this) {
                $reserva->setUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Venta>
     */
    public function getVentasAprobadas(): Collection
    {
        return $this->ventasAprobadas;
    }

    public function addVentasAprobada(Venta $ventasAprobada): self
    {
        if (!$this->ventasAprobadas->contains($ventasAprobada)) {
            $this->ventasAprobadas->add($ventasAprobada);
            $ventasAprobada->setAprobada($this);
        }

        return $this;
    }

    public function removeVentasAprobada(Venta $ventasAprobada): self
    {
        if ($this->ventasAprobadas->removeElement($ventasAprobada)) {
            // set the owning side to null (unless already changed)
            if ($ventasAprobada->getAprobada() === $this) {
                $ventasAprobada->setAprobada(null);
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
            $venta->setRealizada($this);
        }

        return $this;
    }

    public function removeVenta(Venta $venta): self
    {
        if ($this->ventas->removeElement($venta)) {
            // set the owning side to null (unless already changed)
            if ($venta->getRealizada() === $this) {
                $venta->setRealizada(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Alumno>
     */
    public function getAlumnos(): Collection
    {
        return $this->alumnos;
    }

    public function addAlumno(Alumno $alumno): self
    {
        if (!$this->alumnos->contains($alumno)) {
            $this->alumnos->add($alumno);
            $alumno->setAprobado($this);
        }

        return $this;
    }

    public function removeAlumno(Alumno $alumno): self
    {
        if ($this->alumnos->removeElement($alumno)) {
            // set the owning side to null (unless already changed)
            if ($alumno->getAprobado() === $this) {
                $alumno->setAprobado(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MovimientoStock>
     */
    public function getMovimientoStocks(): Collection
    {
        return $this->movimientoStocks;
    }

    public function addMovimientoStock(MovimientoStock $movimientoStock): self
    {
        if (!$this->movimientoStocks->contains($movimientoStock)) {
            $this->movimientoStocks->add($movimientoStock);
            $movimientoStock->setRealizado($this);
        }

        return $this;
    }

    public function removeMovimientoStock(MovimientoStock $movimientoStock): self
    {
        if ($this->movimientoStocks->removeElement($movimientoStock)) {
            // set the owning side to null (unless already changed)
            if ($movimientoStock->getRealizado() === $this) {
                $movimientoStock->setRealizado(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Curso>
     */
    public function getCursos(): Collection
    {
        return $this->cursos;
    }

    public function addCurso(Curso $curso): self
    {
        if (!$this->cursos->contains($curso)) {
            $this->cursos->add($curso);
            $curso->setAlumno($this);
        }

        return $this;
    }

    public function removeCurso(Curso $curso): self
    {
        if ($this->cursos->removeElement($curso)) {
            // set the owning side to null (unless already changed)
            if ($curso->getAlumno() === $this) {
                $curso->setAlumno(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->nombre.' '.$this->apellido;
    }


}
