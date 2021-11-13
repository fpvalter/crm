<?php

namespace App\Entity;

use App\Repository\ClienteInfoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=ClienteInfoRepository::class)
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put", "patch"},
 *     denormalizationContext={"groups"={"clienteInfoPost"}}
 * )
 * @ApiFilter(
 *      SearchFilter::class, 
 *      properties={
 *          "cliente.id": "exact",
 *          "cliente.codigo": "exact",
 *          "cliente.cnpj": "exact"
 *      }
 * )
 */
class ClienteInfo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"clienteGet"})
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"clientePost", "clienteGet", "clienteInfoPost"})
     */
    private $credito;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"clientePost", "clienteGet", "clienteInfoPost"})
     */
    private $creditoValidade;

    /**
     * @ORM\OneToOne(targetEntity=Cliente::class, inversedBy="clienteInfo", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"clientePost", "clienteInfoPost"})
     */
    private $cliente;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"clientePost", "clienteGet", "clienteInfoPost"})
     */
    private $diasUltimaCompra;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"clientePost", "clienteGet", "clienteInfoPost"})
     */
    private $r;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"clientePost", "clienteGet", "clienteInfoPost"})
     */
    private $f;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"clientePost", "clienteGet", "clienteInfoPost"})
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
        return $this->creditoValidade;
    }

    public function setCreditoValidade(?\DateTimeInterface $creditoValidade): self
    {
        $this->creditoValidade = $creditoValidade;

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
        return $this->diasUltimaCompra;
    }

    public function setDiasUltimaCompra(?int $diasUltimaCompra): self
    {
        $this->diasUltimaCompra = $diasUltimaCompra;

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
