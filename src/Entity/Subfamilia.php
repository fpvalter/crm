<?php

namespace App\Entity;

use App\Repository\SubfamiliaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put", "patch"},
 *     denormalizationContext={"groups"={"subfamiliaPost"}},
 *     normalizationContext={"groups"={"subfamiliaGet"}}
 * )
 * @ApiFilter(
 *      SearchFilter::class, 
 *      properties={
 *          "codigo": "exact"
 *      }
 * )
 * @ORM\Entity(repositoryClass=SubfamiliaRepository::class)
 */
class Subfamilia
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"produtoPost", "subfamiliaGet"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Familia::class, inversedBy="subfamilias")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"subfamiliaGet", "subfamiliaPost"})
     */
    private $familia;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"subfamiliaGet", "subfamiliaPost"})
     */
    private $codigo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"subfamiliaGet", "subfamiliaPost"})
     */
    private $descricao;

    /**
     * @ORM\OneToMany(targetEntity=Produto::class, mappedBy="subfamilia")
     */
    private $produtos;

    public function __construct()
    {
        $this->produtos = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->descricao;
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

    public function getFamilia(): ?Familia
    {
        return $this->familia;
    }

    public function setFamilia(?Familia $familia): self
    {
        $this->familia = $familia;

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

    /**
     * @return Collection|Produto[]
     */
    public function getProdutos(): Collection
    {
        return $this->produtos;
    }

    public function addProduto(Produto $produto): self
    {
        if (!$this->produtos->contains($produto)) {
            $this->produtos[] = $produto;
            $produto->setSubfamilia($this);
        }

        return $this;
    }

    public function removeProduto(Produto $produto): self
    {
        if ($this->produtos->removeElement($produto)) {
            // set the owning side to null (unless already changed)
            if ($produto->getSubfamilia() === $this) {
                $produto->setSubfamilia(null);
            }
        }

        return $this;
    }
}
