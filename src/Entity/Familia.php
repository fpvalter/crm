<?php

namespace App\Entity;

use App\Repository\FamiliaRepository;
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
 *     denormalizationContext={"groups"={"familiaPost"}},
 *     normalizationContext={"groups"={"familiaGet"}}
 * )
 * @ApiFilter(
 *      SearchFilter::class, 
 *      properties={
 *          "codigo": "exact"
 *      }
 * )
 * @ORM\Entity(repositoryClass=FamiliaRepository::class)
 */
class Familia
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"produtoPost", "subfamiliaPost", "familiaGet", "subfamiliaGet"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"familiaPost", "familiaGet", "subfamiliaGet"})
     */
    private $codigo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"familiaPost", "familiaGet", "subfamiliaGet"})
     */
    private $descricao;

    /**
     * @ORM\OneToMany(targetEntity=Subfamilia::class, mappedBy="familia", orphanRemoval=true)
     * @Groups({"familiaGet"})
     */
    private $subfamilias;

    /**
     * @ORM\OneToMany(targetEntity=Produto::class, mappedBy="familia")
     */
    private $produtos;

    public function __construct()
    {
        $this->subfamilias = new ArrayCollection();
        $this->produtos = new ArrayCollection();
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

    public function setDescricao(?string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * @return Collection|Subfamilia[]
     */
    public function getSubfamilias(): Collection
    {
        return $this->subfamilias;
    }

    public function addSubfamilia(Subfamilia $subfamilia): self
    {
        if (!$this->subfamilias->contains($subfamilia)) {
            $this->subfamilias[] = $subfamilia;
            $subfamilia->setFamilia($this);
        }

        return $this;
    }

    public function removeSubfamilia(Subfamilia $subfamilia): self
    {
        if ($this->subfamilias->removeElement($subfamilia)) {
            // set the owning side to null (unless already changed)
            if ($subfamilia->getFamilia() === $this) {
                $subfamilia->setFamilia(null);
            }
        }

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
            $produto->setFamilia($this);
        }

        return $this;
    }

    public function removeProduto(Produto $produto): self
    {
        if ($this->produtos->removeElement($produto)) {
            // set the owning side to null (unless already changed)
            if ($produto->getFamilia() === $this) {
                $produto->setFamilia(null);
            }
        }

        return $this;
    }
}
