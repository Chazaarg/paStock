<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VendedorHistoricoRepository")
 */
class VendedorHistorico
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
    private $apellido;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $apodo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Venta", mappedBy="vendedorHistorico")
     */
    private $ventas;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="vendedorHistoricos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $vendedor;

    public function __construct($user)
    {
        $this->user = $user;
        $this->ventas = new ArrayCollection();
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

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): self
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getApodo(): ?string
    {
        return $this->apodo;
    }

    public function setApodo(?string $apodo): self
    {
        $this->apodo = $apodo;

        return $this;
    }

    /**
     * @return Collection|Venta[]
     */
    public function getVentas(): Collection
    {
        return $this->ventas;
    }

    public function addVenta(Venta $venta): self
    {
        if (!$this->ventas->contains($venta)) {
            $this->ventas[] = $venta;
            $venta->setVendedorHistorico($this);
        }

        return $this;
    }

    public function removeVenta(Venta $venta): self
    {
        if ($this->ventas->contains($venta)) {
            $this->ventas->removeElement($venta);
            // set the owning side to null (unless already changed)
            if ($venta->getVendedorHistorico() === $this) {
                $venta->setVendedorHistorico(null);
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

    public function getVendedor(): ?int
    {
        return $this->vendedor;
    }

    public function setVendedor(int $vendedor): self
    {
        $this->vendedor = $vendedor;

        return $this;
    }
}
