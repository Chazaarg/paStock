<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VarianteTipoRepository")
 * @UniqueEntity("nombre", message ="El tipo de variante ingresado ya existe.")
 */
class VarianteTipo
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
     * @ORM\OneToMany(targetEntity="App\Entity\Variante", mappedBy="varianteTipo")
     */
    private $variante;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="varianteTipos")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    public function __construct($user)
    {
        $this->variante = new ArrayCollection();
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

    /**
     * @return Collection|Variante[]
     */
    public function getVariante(): Collection
    {
        return $this->variante;
    }

    public function addVariante(Variante $variante): self
    {
        if (!$this->variante->contains($variante)) {
            $this->variante[] = $variante;
            $variante->setVarianteTipo($this);
        }

        return $this;
    }

    public function removeVariante(Variante $variante): self
    {
        if ($this->variante->contains($variante)) {
            $this->variante->removeElement($variante);
            // set the owning side to null (unless already changed)
            if ($variante->getVarianteTipo() === $this) {
                $variante->setVarianteTipo(null);
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
                'nombre'        => $this->nombre,
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
