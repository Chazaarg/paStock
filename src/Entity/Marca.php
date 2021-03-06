<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MarcaRepository")
 * @UniqueEntity("nombre", message ="La marca ingresada ya existe.")
 */
class Marca
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Este campo es requerido.")
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $origen;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pagina;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Producto", mappedBy="marca")
     */
    private $productos;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="marcas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct($user)
    {
        $this->productos = new ArrayCollection();
        $this->user = $user;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getOrigen(): ?string
    {
        return $this->origen;
    }

    public function setOrigen(?string $origen): self
    {
        $this->origen = $origen;

        return $this;
    }

    public function getPagina(): ?string
    {
        return $this->pagina;
    }

    public function setPagina(?string $pagina): self
    {
        $this->pagina = $pagina;

        return $this;
    }

    /**
     * @return Collection|Producto[]
     */
    public function getProductos(): Collection
    {
        return $this->productos;
    }

    public function addProducto(Producto $producto): self
    {
        if (!$this->productos->contains($producto)) {
            $this->productos[] = $producto;
            $producto->setMarca($this);
        }

        return $this;
    }

    public function removeProducto(Producto $producto): self
    {
        if ($this->productos->contains($producto)) {
            $this->productos->removeElement($producto);
            // set the owning side to null (unless already changed)
            if ($producto->getMarca() === $this) {
                $producto->setMarca(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->nombre;
    }
    public function jsonSerialize(): array
    {
        return [
            "id"           => $this->id,
            "nombre"        => $this->nombre,
            "origen"        => $this->origen ? $this->origen : null,
            "pagina"        => $this->pagina ? $this->pagina : null
        ];
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        return $this;
    }
}
