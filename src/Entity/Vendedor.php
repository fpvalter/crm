<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\VendedorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=VendedorRepository::class)
 */
class Vendedor
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"clientePost"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codigo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nome;

    /**
     * @ORM\OneToMany(targetEntity=Cliente::class, mappedBy="vendedor")
     */
    private $clientes;

    public function __construct()
    {
        $this->clientes = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->codigo . " - " . $this->nome;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(?string $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * @return Collection|Cliente[]
     */
    public function getClientes(): Collection
    {
        return $this->clientes;
    }

    public function addCliente(Cliente $cliente): self
    {
        if (!$this->clientes->contains($cliente)) {
            $this->clientes[] = $cliente;
            $cliente->setVendedor($this);
        }

        return $this;
    }

    public function removeCliente(Cliente $cliente): self
    {
        if ($this->clientes->removeElement($cliente)) {
            // set the owning side to null (unless already changed)
            if ($cliente->getVendedor() === $this) {
                $cliente->setVendedor(null);
            }
        }

        return $this;
    }
}
