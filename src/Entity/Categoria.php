<?php

namespace App\Entity;

use App\Repository\CategoriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoriaRepository::class)
 */
class Categoria
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nome;

    /**
     * @ORM\OneToMany(targetEntity=Despesas::class, mappedBy="categoria")
     */
    private $despesas;

    public function __construct()
    {
        $this->despesas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection<int, Despesas>
     */
    public function getDespesas(): Collection
    {
        return $this->despesas;
    }

    public function addDespesa(Despesas $despesa): self
    {
        if (!$this->despesas->contains($despesa)) {
            $this->despesas[] = $despesa;
            $despesa->setCategoria($this);
        }

        return $this;
    }

    public function removeDespesa(Despesas $despesa): self
    {
        if ($this->despesas->removeElement($despesa)) {
            // set the owning side to null (unless already changed)
            if ($despesa->getCategoria() === $this) {
                $despesa->setCategoria(null);
            }
        }

        return $this;
    }
}
