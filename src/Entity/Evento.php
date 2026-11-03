<?php

namespace App\Entity;

use App\Common\Util;
use App\Repository\EventoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[ORM\Entity(repositoryClass: EventoRepository::class)]
#[UniqueEntity(
    fields: ['slug'],
    message: 'Ya existe un evento con ese título.',
    errorPath: 'titulo'
)]
class Evento
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(
        message: 'El título del evento es obligatorio.'
    )]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: 'El título debe tener al menos {{ limit }} caracteres.',
        maxMessage: 'El título no puede superar los {{ limit }} caracteres.'
    )]
    private ?string $titulo = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(
        message: 'Debe ingresar el idioma del evento.'
    )]
    private ?string $idioma = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(
        message: 'Debe ingresar una descripción del evento.'
    )]
    private ?string $descripcion = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(
        message: 'Debe ingresar la fecha del evento.'
    )]
    private ?\DateTime $fecha = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotNull(
        message: 'Debe ingresar la hora del evento.'
    )]
    private ?\DateTime $hora = null;

    #[ORM\Column]
    #[Assert\NotNull(
        message: 'Debe ingresar la duración del evento.'
    )]
    #[Assert\Positive(
        message: 'La duración debe ser mayor que cero.'
    )]
    private ?int $duracion = null;

    #[ORM\ManyToOne(inversedBy: 'eventos')]
    private ?Disertante $disertante = null;

    /**
     * @var Collection<int, Usuario>
     */
    #[ORM\ManyToMany(targetEntity: Usuario::class, inversedBy: 'eventos')]
    private Collection $usuarios;

    #[ORM\Column]
    #[Assert\NotNull(
        message: 'Debe ingresar la capacidad del evento.'
    )]
    #[Assert\Positive(
        message: 'La capacidad debe ser mayor que cero.'
    )]
    private ?int $capacidad = null;

    public function __construct()
    {
        $this->usuarios = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): static
    {
        $this->titulo = $titulo;

        $this->slug = Util::slugify($titulo);

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getIdioma(): ?string
    {
        return $this->idioma;
    }

    public function setIdioma(string $idioma): static
    {
        $this->idioma = $idioma;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getFecha(): ?\DateTime
    {
        return $this->fecha;
    }

    public function setFecha(\DateTime $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getHora(): ?\DateTime
    {
        return $this->hora;
    }

    public function setHora(\DateTime $hora): static
    {
        $this->hora = $hora;

        return $this;
    }

    public function getDuracion(): ?int
    {
        return $this->duracion;
    }

    public function setDuracion(int $duracion): static
    {
        $this->duracion = $duracion;

        return $this;
    }

    public function getDisertante(): ?Disertante
    {
        return $this->disertante;
    }

    public function setDisertante(?Disertante $disertante): static
    {
        $this->disertante = $disertante;

        return $this;
    }

    /**
     * @return Collection<int, Usuario>
     */
    public function getUsuarios(): Collection
    {
        return $this->usuarios;
    }

    public function addUsuario(Usuario $usuario): static
    {
        if (!$this->usuarios->contains($usuario)) {
            $this->usuarios->add($usuario);
            $usuario->addEvento($this);
        }

        return $this;
    }

    public function removeUsuario(Usuario $usuario): static
    {
        if ($this->usuarios->removeElement($usuario)) {
            $usuario->removeEvento($this);
        }

        return $this;
    }
    public function getHoraFinalizacion(): \DateTimeInterface
    {
        $horaFinal = clone $this->hora;

        return $horaFinal->add(
            new \DateInterval('PT' . $this->duracion . 'M')
        );
    }

    public function __toString(): string
    {
        return $this->titulo ?? '';
    }

    public function getCapacidad(): ?int
    {
        return $this->capacidad;
    }

    public function setCapacidad(int $capacidad): static
    {
        $this->capacidad = $capacidad;

        return $this;
    }
}
