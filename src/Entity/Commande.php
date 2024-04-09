<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $QteC = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateCommande = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?Client $Client = null;

    #[ORM\ManyToMany(targetEntity: Materiel::class, inversedBy: 'commandes')]
    private Collection $Materiel;

    public function __construct()
    {
        $this->Materiel = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQteC(): ?int
    {
        return $this->QteC;
    }

    public function setQteC(int $QteC): static
    {
        $this->QteC = $QteC;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->DateCommande;
    }

    public function setDateCommande(\DateTimeInterface $DateCommande): static
    {
        $this->DateCommande = $DateCommande;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->Client;
    }

    public function setClient(?Client $Client): static
    {
        $this->Client = $Client;

        return $this;
    }

    /**
     * @return Collection<int, Materiel>
     */
    public function getMateriel(): Collection
    {
        return $this->Materiel;
    }

    public function addMateriel(Materiel $materiel): static
    {
        if (!$this->Materiel->contains($materiel)) {
            $this->Materiel->add($materiel);
        }

        return $this;
    }

    public function removeMateriel(Materiel $materiel): static
    {
        $this->Materiel->removeElement($materiel);

        return $this;
    }
}
