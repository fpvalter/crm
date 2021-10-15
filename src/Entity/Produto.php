<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProdutoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ProdutoRepository::class)
 */
class Produto
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codigo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descricao;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $categoria;

    /**
     * @ORM\OneToMany(targetEntity=ProdutoEstabelecimento::class, mappedBy="produto", orphanRemoval=true)
     */
    private $produtoEstabelecimentos;

    public function __construct()
    {
        $this->produtoEstabelecimentos = new ArrayCollection();
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

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getCategoria(): ?string
    {
        return $this->categoria;
    }

    public function setCategoria(?string $categoria): self
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * @return Collection|ProdutoEstabelecimento[]
     */
    public function getProdutoEstabelecimentos(): Collection
    {
        return $this->produtoEstabelecimentos;
    }

    public function addProdutoEstabelecimento(ProdutoEstabelecimento $produtoEstabelecimento): self
    {
        if (!$this->produtoEstabelecimentos->contains($produtoEstabelecimento)) {
            $this->produtoEstabelecimentos[] = $produtoEstabelecimento;
            $produtoEstabelecimento->setProduto($this);
        }

        return $this;
    }

    public function removeProdutoEstabelecimento(ProdutoEstabelecimento $produtoEstabelecimento): self
    {
        if ($this->produtoEstabelecimentos->removeElement($produtoEstabelecimento)) {
            // set the owning side to null (unless already changed)
            if ($produtoEstabelecimento->getProduto() === $this) {
                $produtoEstabelecimento->setProduto(null);
            }
        }

        return $this;
    }
}
