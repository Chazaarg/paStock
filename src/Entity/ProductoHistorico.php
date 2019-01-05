<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductoHistoricoRepository")
 */
class ProductoHistorico
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $marca;

    /**
     * @ORM\Column(type="float")
     */
    private $precio;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codigoDeBarras;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $categoria;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subcategoria;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VentaDetalle", mappedBy="productoHistorico")
     */
    private $ventaDetalles;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="productoHistoricos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

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

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getMarca(): ?string
    {
        return $this->marca;
    }

    public function setMarca(string $marca): self
    {
        $this->marca = $marca;

        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): self
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

    public function getCategoria(): ?string
    {
        return $this->categoria;
    }

    public function setCategoria(?string $categoria): self
    {
        $this->categoria = $categoria;

        return $this;
    }

    public function getSubcategoria(): ?string
    {
        return $this->subcategoria;
    }

    public function setSubcategoria(?string $subcategoria): self
    {
        $this->subcategoria = $subcategoria;

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
            $ventaDetalle->setProductoHistorico($this);
        }

        return $this;
    }

    public function removeVentaDetalle(VentaDetalle $ventaDetalle): self
    {
        if ($this->ventaDetalles->contains($ventaDetalle)) {
            $this->ventaDetalles->removeElement($ventaDetalle);
            // set the owning side to null (unless already changed)
            if ($ventaDetalle->getProductoHistorico() === $this) {
                $ventaDetalle->setProductoHistorico(null);
            }
        }

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
}
