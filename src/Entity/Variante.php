<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VarianteRepository")
 */
class Variante
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
     * @ORM\ManyToOne(targetEntity="App\Entity\VarianteTipo", inversedBy="variante")
     * @Assert\NotBlank(message="Este campo es requerido.")
     */
    private $varianteTipo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Producto", inversedBy="variantes")
     */
    private $producto;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Este campo es requerido.")
     */
    private $cantidad;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Este campo es requerido.")
     */
    private $precio;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codigoDeBarras;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="variantes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VentaDetalle", mappedBy="variante")
     */
    private $ventaDetalles;

    public function __construct()
    {
        $this->ventaDetalles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(?string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getVarianteTipo(): ?VarianteTipo
    {
        return $this->varianteTipo;
    }

    public function setVarianteTipo(?VarianteTipo $varianteTipo): self
    {
        $this->varianteTipo = $varianteTipo;

        return $this;
    }

    public function getProducto(): ?Producto
    {
        return $this->producto;
    }

    public function setProducto(?Producto $producto): self
    {
        $this->producto = $producto;

        return $this;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(?int $cantidad): self
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id'           => $this->id,
            'nombre'        => $this->nombre,
            'cantidad' => $this->cantidad,
            'precio' => $this->precio,
            'variante_tipo' => $this->varianteTipo ? array('nombre' => $this->varianteTipo->getNombre(), 'id' => $this->varianteTipo->getId()) : "",
            'codigo_de_barras' => $this->codigoDeBarras ? $this->codigoDeBarras : "",

        ];
    }

    public function getPrecio(): ?int
    {
        return $this->precio;
    }

    public function setPrecio(?int $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getCodigoDeBarras(): ?string
    {
        return $this->codigoDeBarras;
    }

    public function setCodigoDeBarras(?string $codigoDeBarras): self
    {
        $this->codigoDeBarras = $codigoDeBarras;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|VentaDetalle[]
     */
    public function getVentaDetalles(): Collection
    {
        return $this->ventaDetalles;
    }

    public function addVentaDetalle(VentaDetalle $ventaDetalle): self
    {
        if (!$this->ventaDetalles->contains($ventaDetalle)) {
            $this->ventaDetalles[] = $ventaDetalle;
            $ventaDetalle->setVariante($this);
        }

        return $this;
    }

    public function removeVentaDetalle(VentaDetalle $ventaDetalle): self
    {
        if ($this->ventaDetalles->contains($ventaDetalle)) {
            $this->ventaDetalles->removeElement($ventaDetalle);
            // set the owning side to null (unless already changed)
            if ($ventaDetalle->getVariante() === $this) {
                $ventaDetalle->setVariante(null);
            }
        }

        return $this;
    }
}
