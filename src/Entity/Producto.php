<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductoRepository")
 */
class Producto implements \JsonSerializable
{
    use TimestampableEntity;

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
     * @Assert\NotBlank(message="Este campo es requerido.", groups={"individual"})
     * @ORM\Column(type="float", nullable=true)
     */
    private $precio;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codigoDeBarras;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $precioCompra;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $precioReal;

    /**
     * @Assert\NotBlank(message="Este campo es requerido.", groups={"individual"})
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cantidad;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Marca", inversedBy="productos")
     */
    private $marca;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categoria", inversedBy="productos")
     * @ORM\JoinColumn(nullable=true)
     */
    private $categoria;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Variante", mappedBy="producto",cascade={"persist"})
     */
    private $variantes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SubCategoria", inversedBy="productos")
     */
    private $subCategoria;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="productos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VentaDetalle", mappedBy="producto")
     */
    private $ventaDetalles;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $precioPromedio;

    /**
     * @ORM\Column(type="integer")
     */
    private $cantidadPromedio;

    public function __construct($user)
    {
        $this->user = $user;
        $this->variantes = new ArrayCollection();
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

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(?float $precio): self
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

    public function getPrecioCompra(): ?float
    {
        return $this->precioCompra;
    }

    public function setPrecioCompra(?float $precioCompra): self
    {
        $this->precioCompra = $precioCompra;

        return $this;
    }

    public function getPrecioReal(): ?float
    {
        return $this->precioReal;
    }

    public function setPrecioReal(?float $precioReal): self
    {
        $this->precioReal = $precioReal;

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

    public function getMarca(): ?Marca
    {
        return $this->marca;
    }

    public function setMarca(?Marca $marca): self
    {
        $this->marca = $marca;

        return $this;
    }

    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?Categoria $categoria): self
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * @return Collection|Variante[]
     */
    public function getVariantes(): Collection
    {
        return $this->variantes;
    }

    public function addVariante(Variante $variante): self
    {
        if (!$this->variantes->contains($variante)) {
            $this->variantes[] = $variante;
            $variante->setProducto($this);
        }

        return $this;
    }

    public function removeVariante(Variante $variante): self
    {
        if ($this->variantes->contains($variante)) {
            $this->variantes->removeElement($variante);
            // set the owning side to null (unless already changed)
            if ($variante->getProducto() === $this) {
                $variante->setProducto(null);
            }
        }

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'cantidad' => $this->cantidad ? $this->cantidad : 0,
            'precio' => $this->precio ? $this->precio : 0,
            'marca' => $this->marca ? array('nombre' => $this->marca->getNombre(), 'id' => $this->marca->getId()) : "",
            'categoria' => $this->categoria ? array('nombre' => $this->categoria->getNombre(), 'id' => $this->categoria->getId()) : "",
            'sub_categoria' => $this->subCategoria ? array('nombre' => $this->subCategoria->getNombre(), 'id' => $this->subCategoria->getId()) : null,
            'updated_at' => $this->updatedAt ? $this->updatedAt : "",
            'created_at' => $this->createdAt ? $this->createdAt : "",
            'codigo_de_barras' => $this->codigoDeBarras ? $this->codigoDeBarras : "",
            'precio_compra' => $this->precioCompra ? $this->precioCompra : "",
            'precio_real' => $this->precioReal ? $this->precioReal : "",
            'descripcion' => $this->descripcion ? $this->descripcion : "",
        ];
    }

    public function getSubCategoria(): ?SubCategoria
    {
        return $this->subCategoria;
    }

    public function setSubCategoria(?SubCategoria $subCategoria): self
    {
        $this->subCategoria = $subCategoria;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
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
            $ventaDetalle->setProducto($this);
        }

        return $this;
    }

    public function removeVentaDetalle(VentaDetalle $ventaDetalle): self
    {
        if ($this->ventaDetalles->contains($ventaDetalle)) {
            $this->ventaDetalles->removeElement($ventaDetalle);
            // set the owning side to null (unless already changed)
            if ($ventaDetalle->getProducto() === $this) {
                $ventaDetalle->setProducto(null);
            }
        }

        return $this;
    }

    public function getPrecioPromedio(): ?float
    {
        return $this->precioPromedio;
    }

    public function setPrecioPromedio(?float $precioPromedio): self
    {
        $this->precioPromedio = $precioPromedio;

        return $this;
    }

    public function getCantidadPromedio(): ?int
    {
        return $this->cantidadPromedio;
    }

    public function setCantidadPromedio(int $cantidadPromedio): self
    {
        $this->cantidadPromedio = $cantidadPromedio;

        return $this;
    }
}
