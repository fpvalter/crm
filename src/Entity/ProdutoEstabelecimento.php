<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProdutoEstabelecimentoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ProdutoEstabelecimentoRepository::class)
 */
class ProdutoEstabelecimento
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Estabelecimento::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $estabelecimento;

    /**
     * @ORM\ManyToOne(targetEntity=Produto::class, inversedBy="produtoEstabelecimentos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $produto;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $dias_ultima_venda;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $diferenca_entrada_saida;

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

    public function getDiasUltimaVenda(): ?int
    {
        return $this->dias_ultima_venda;
    }

    public function setDiasUltimaVenda(?int $dias_ultima_venda): self
    {
        $this->dias_ultima_venda = $dias_ultima_venda;

        return $this;
    }

    public function getDiferencaEntradaSaida(): ?float
    {
        return $this->diferenca_entrada_saida;
    }

    public function setDiferencaEntradaSaida(?float $diferenca_entrada_saida): self
    {
        $this->diferenca_entrada_saida = $diferenca_entrada_saida;

        return $this;
    }
}
