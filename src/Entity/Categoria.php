<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoriaRepository")
 * @UniqueEntity("nombre", message ="La categoría ingresada ya existe.")
 */
class Categoria
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
     * @ORM\OneToMany(targetEntity="App\Entity\Producto", mappedBy="categoria")
     */
    private $productos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SubCategoria", mappedBy="categoria")
     */
    private $subCategoria;

    public function __construct()
    {
        $this->productos = new ArrayCollection();
        $this->subCategoria = new ArrayCollection();
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
            $producto->setCategoria($this);
        }

        return $this;
    }

    public function removeProducto(Producto $producto): self
    {
        if ($this->productos->contains($producto)) {
            $this->productos->removeElement($producto);
            // set the owning side to null (unless already changed)
            if ($producto->getCategoria() === $this) {
                $producto->setCategoria(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SubCategoria[]
     */
    public function getSubCategoria(): Collection
    {
        return $this->subCategoria;
    }

    public function addSubCategorium(SubCategoria $subCategorium): self
    {
        if (!$this->subCategoria->contains($subCategorium)) {
            $this->subCategoria[] = $subCategorium;
            $subCategorium->setCategoria($this);
        }

        return $this;
    }

    public function removeSubCategorium(SubCategoria $subCategorium): self
    {
        if ($this->subCategoria->contains($subCategorium)) {
            $this->subCategoria->removeElement($subCategorium);
            // set the owning side to null (unless already changed)
            if ($subCategorium->getCategoria() === $this) {
                $subCategorium->setCategoria(null);
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
            'id'           => $this->id,
            'nombre'        => $this->nombre
        ];
    }

}
