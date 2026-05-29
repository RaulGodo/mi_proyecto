<?php

namespace App\Entity;

use App\Repository\EventoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use app\Common\Util;

#[ORM\Entity(repositoryClass: EventoRepository::class)]
class Evento
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titulo = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $fecha = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $hora = null;

    #[ORM\Column]
    private ?int $duracion = null;

    #[ORM\Column(length: 255)]
    private ?string $idioma = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    /**
     * @var Collection<int, Disertante>
     */
    #[ORM\ManyToMany(targetEntity: Disertante::class, inversedBy: 'eventos')]
    private Collection $disertante;

    /**
     * @var Collection<int, Usuario>
     */
    #[ORM\ManyToMany(targetEntity: Usuario::class, mappedBy: 'evento')]
    private Collection $usuarios;

    public function __construct()
    {
        $this->disertante = new ArrayCollection();
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
        $this->setSlug($titulo);

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

    public function getIdioma(): ?string
    {
        return $this->idioma;
    }

    public function setIdioma(string $idioma): static
    {
        $this->idioma = $idioma;

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

    /**
     * @return Collection<int, Disertante>
     */
    public function getDisertante(): Collection
    {
        return $this->disertante;
    }

    public function addDisertante(Disertante $disertante): static
    {
        if (!$this->disertante->contains($disertante)) {
            $this->disertante->add($disertante);
        }

        return $this;
    }

    public function removeDisertante(Disertante $disertante): static
    {
        $this->disertante->removeElement($disertante);

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
        return $this->titulo;
    }
}
