<?php

namespace App\Entity;

use App\Repository\ClienteInfoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClienteInfoRepository::class)
 */
class ClienteInfo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $credito;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $credito_validade;

    /**
     * @ORM\OneToOne(targetEntity=Cliente::class, inversedBy="clienteInfo", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $cliente;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $dias_ultima_compra;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $r;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $f;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $v;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCredito(): ?float
    {
        return $this->credito;
    }

    public function setCredito(?float $credito): self
    {
        $this->credito = $credito;

        return $this;
    }

    public function getCreditoValidade(): ?\DateTimeInterface
    {
        return $this->credito_validade;
    }

    public function setCreditoValidade(?\DateTimeInterface $credito_validade): self
    {
        $this->credito_validade = $credito_validade;

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

    public function getDiasUltimaCompra(): ?int
    {
        return $this->dias_ultima_compra;
    }

    public function setDiasUltimaCompra(?int $dias_ultima_compra): self
    {
        $this->dias_ultima_compra = $dias_ultima_compra;

        return $this;
    }

    public function getR(): ?int
    {
        return $this->r;
    }

    public function setR(?int $r): self
    {
        $this->r = $r;

        return $this;
    }

    public function getF(): ?int
    {
        return $this->f;
    }

    public function setF(?int $f): self
    {
        $this->f = $f;

        return $this;
    }

    public function getV(): ?int
    {
        return $this->v;
    }

    public function setV(?int $v): self
    {
        $this->v = $v;

        return $this;
    }
}
