<?php

namespace App\Entity;

use App\Repository\ProdutoEstabelecimentoRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProdutoEstabelecimentoRepository::class)
 * @ApiResource(
 *      collectionOperations={"get", "post"},
 *      itemOperations={"get", "put", "patch"}
 * )
 * @ApiFilter(
 *      SearchFilter::class, 
 *      properties={
 *          "estabelecimento.codigo": "exact",
 *          "estabelecimento.cnpj": "exact",
 *          "produto.codigo": "exact"
 *      }
 * )
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
     * @Groups({"produtoPost"})
     */
    private $estabelecimento;

    /**
     * @ORM\ManyToOne(targetEntity=Produto::class, inversedBy="produtoEstabelecimentos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $produto;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"produtoPost"})
     */
    private $diasUltimaVenda;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"produtoPost"})
     */
    private $diferencaEntradaSaida;

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
        return $this->diasUltimaVenda;
    }

    public function setDiasUltimaVenda(?int $diasUltimaVenda): self
    {
        $this->diasUltimaVenda = $diasUltimaVenda;

        return $this;
    }

    public function getDiferencaEntradaSaida(): ?float
    {
        return $this->diferencaEntradaSaida;
    }

    public function setDiferencaEntradaSaida(?float $diferencaEntradaSaida): self
    {
        $this->diferencaEntradaSaida = $diferencaEntradaSaida;

        return $this;
    }
}
