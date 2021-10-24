<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\NotaFiscalRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ApiResource(
 *      collectionOperations={"get", "post"},
 *      itemOperations={"get", "put", "patch"},
 *      denormalizationContext={"groups"={"notaFiscalPost"}}
 * )
 * @ORM\Entity(repositoryClass=NotaFiscalRepository::class)
 */
class NotaFiscal
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Estabelecimento::class, inversedBy="notaFiscals")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"notaFiscalPost"})
     */
    private $estabelecimento;

    /**
     * @ORM\ManyToOne(targetEntity=Cliente::class, inversedBy="notaFiscals")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"notaFiscalPost"})
     */
    private $cliente;

    /**
     * @ORM\ManyToOne(targetEntity=Produto::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"notaFiscalPost"})
     */
    private $produto;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"notaFiscalPost"})
     */
    private $numero;

    /**
     * @ORM\Column(type="string", length=10)
     * @Groups({"notaFiscalPost"})
     */
    private $serie;

    /**
     * @ORM\Column(type="date")
     * @Groups({"notaFiscalPost"})
     */
    private $emissao;

    /**
     * @ORM\Column(type="float")
     * @Groups({"notaFiscalPost"})
     */
    private $quantidade;

    /**
     * @ORM\Column(type="float")
     * @Groups({"notaFiscalPost"})
     */
    private $valorUnitario;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEstabelecimento(): ?Estabelecimento
    {
        return $this->estabelecimento;
    }

    public function setEstabelecimento(?Estabelecimento $estabelecimento): self
    {
        $this->estabelecimento = $estabelecimento;

        return $this;
    }

    public function getProduto(): ?Produto
    {
        return $this->produto;
    }

    public function setProduto(?Produto $produto): self
    {
        $this->produto = $produto;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getSerie(): ?string
    {
        return $this->serie;
    }

    public function setSerie(string $serie): self
    {
        $this->serie = $serie;

        return $this;
    }

    public function getEmissao(): ?\DateTimeInterface
    {
        return $this->emissao;
    }

    public function setEmissao(\DateTimeInterface $emissao): self
    {
        $this->emissao = $emissao;

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

    public function getQuantidade(): ?float
    {
        return $this->quantidade;
    }

    public function setQuantidade(float $quantidade): self
    {
        $this->quantidade = $quantidade;

        return $this;
    }

    public function getValorUnitario(): ?float
    {
        return $this->valorUnitario;
    }

    public function setValorUnitario(float $valorUnitario): self
    {
        $this->valorUnitario = $valorUnitario;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
