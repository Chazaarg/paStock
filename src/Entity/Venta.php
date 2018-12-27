<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VentaRepository")
 */
class Venta
{
    /**
     * @var \DateTime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $total;

    /**
     * @ORM\Column(type="integer")
     */
    private $descuento;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cliente", inversedBy="ventas")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Este campo es requerido.")
     */
    private $cliente;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Vendedor", inversedBy="ventas")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Este campo es requerido.")
     */
    private $vendedor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FormaDePago", inversedBy="ventas")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Este campo es requerido.")
     */
    private $formaDePago;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="ventas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VentaDetalle", mappedBy="venta")
     */
    private $ventaDetalles;

    public function __construct($user)
    {
        $this->ventaDetalles = new ArrayCollection();
        $this->user = $user;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getDescuento(): ?int
    {
        return $this->descuento;
    }

    public function setDescuento(int $descuento): self
    {
        $this->descuento = $descuento;

        return $this;
    }

    public function getCliente(): ?Cliente
    {
        return $this->cliente;
    }

    public function setCliente(?Cliente $cliente): self
    {
        $this->cliente = $cliente;

        return $this;
    }

    public function getVendedor(): ?Vendedor
    {
        return $this->vendedor;
    }

    public function setVendedor(?Vendedor $vendedor): self
    {
        $this->vendedor = $vendedor;

        return $this;
    }

    public function getFormaDePago(): ?FormaDePago
    {
        return $this->formaDePago;
    }

    public function setFormaDePago(?FormaDePago $formaDePago): self
    {
        $this->formaDePago = $formaDePago;

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
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
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
            $ventaDetalle->setVenta($this);
        }

        return $this;
    }

    public function removeVentaDetalle(VentaDetalle $ventaDetalle): self
    {
        if ($this->ventaDetalles->contains($ventaDetalle)) {
            $this->ventaDetalles->removeElement($ventaDetalle);
            // set the owning side to null (unless already changed)
            if ($ventaDetalle->getVenta() === $this) {
                $ventaDetalle->setVenta(null);
            }
        }

        return $this;
    }
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'cliente' => $this->cliente->getNombre() ." ". $this->cliente->getApellido(),
            'vendedor' => $this->vendedor->getNombre() ." ". $this->vendedor->getApellido(),
            "total" => $this->total,
            "descuento" => $this->descuento,
            "createdAt" => $this->createdAt
        ];
    }
}
