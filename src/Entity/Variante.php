<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $nombre;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VarianteTipo", inversedBy="variante")
     */
    private $varianteTipo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Producto", inversedBy="variantes")
     */
    private $producto;

    /**
     * @ORM\Column(type="integer")
     */
    private $Cantidad;

    /**
     * @ORM\Column(type="integer")
     */
    private $precio;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codigoDeBarras;

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
        return $this->Cantidad;
    }

    public function setCantidad(int $Cantidad): self
    {
        $this->Cantidad = $Cantidad;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id'           => $this->id,
            'nombre'        => $this->nombre,
            'cantidad' => $this->Cantidad ? $this->Cantidad : null,
            'precio' => $this->precio,
            'variante_tipo' => $this->varianteTipo ? array('nombre' => $this->varianteTipo->getNombre(), 'id' => $this->varianteTipo->getId()) : null,
            'codigo_de_barras' => $this->codigoDeBarras ? $this->codigoDeBarras : null,

        ];
    }

    public function getPrecio(): ?int
    {
        return $this->precio;
    }

    public function setPrecio(int $precio): self
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
}
