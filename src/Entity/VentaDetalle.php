<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VentaDetalleRepository")
 */
class VentaDetalle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Venta", inversedBy="ventaDetalles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $venta;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Producto", inversedBy="ventaDetalles")
     * @ORM\JoinColumn(nullable=true)
     * @Assert\NotBlank(message="Introduzca un producto válido.")
     */
    private $producto;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Este campo es requerido.")
     */
    private $cantidad;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="ventaDetalles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Este campo es requerido.")
     */
    private $precio;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Variante", inversedBy="ventaDetalles")
     */
    private $variante;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProductoHistorico", inversedBy="ventaDetalles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productoHistorico;
    
    public function __construct($user)
    {
        $this->user = $user;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVenta(): ?Venta
    {
        return $this->venta;
    }

    public function setVenta(?Venta $venta): self
    {
        $this->venta = $venta;

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

    public function setCantidad(int $cantidad): self
    {
        $this->cantidad = $cantidad;

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

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getVariante(): ?Variante
    {
        return $this->variante;
    }

    public function setVariante(?Variante $variante): self
    {
        $this->variante = $variante;

        return $this;
    }
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'venta' => $this->venta,
            'producto' => ["nombre" => $this->productoHistorico->getNombre(), "marca" =>  $this->productoHistorico->getMarca(), "id" => $this->productoHistorico->getProducto()],
            "cantidad" => $this->cantidad,
            "precio" => $this->precio,
            "variante" => $this->productoHistorico->getVariante() ? ["nombre" => $this->productoHistorico->getVariante(), "varianteTipo" => $this->productoHistorico->getVarianteTipo(), "id" => $this->productoHistorico->getVarianteId()] : null
        ];
    }

    public function getProductoHistorico(): ?ProductoHistorico
    {
        return $this->productoHistorico;
    }

    public function setProductoHistorico(?ProductoHistorico $productoHistorico): self
    {
        $this->productoHistorico = $productoHistorico;

        return $this;
    }
}
