<?php

namespace App\Entity;

use App\Repository\VendeurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VendeurRepository::class)]
class Vendeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Vendeur = null;


    #[ORM\Column(length: 255)]
    private ?string $Siege = null;

    #[ORM\Column(length: 255)]
    private ?string $TelE = null;

    #[ORM\OneToMany(targetEntity: Materiel::class, mappedBy: 'Vendeur')]
    private Collection $materiels;

    #[ORM\OneToOne(inversedBy: 'vendeur', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    public function __construct()
    {
        $this->materiels = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVendeur(): ?string
    {
        return $this->Vendeur;
    }

    public function setVendeur(string $Vendeur): static
    {
        $this->Vendeur = $Vendeur;

        return $this;
    }

    public function getSiege(): ?string
    {
        return $this->Siege;
    }

    public function setSiege(string $Siege): static
    {
        $this->Siege = $Siege;

        return $this;
    }

    public function getTelE(): ?string
    {
        return $this->TelE;
    }

    public function setTelE(string $TelE): static
    {
        $this->TelE = $TelE;

        return $this;
    }

    /**
     * @return Collection<int, Materiel>
     */
    public function getMateriels(): Collection
    {
        return $this->materiels;
    }

    public function addMateriel(Materiel $materiel): static
    {
        if (!$this->materiels->contains($materiel)) {
            $this->materiels->add($materiel);
            $materiel->setVendeur($this);
        }

        return $this;
    }

    public function removeMateriel(Materiel $materiel): static
    {
        if ($this->materiels->removeElement($materiel)) {
            // set the owning side to null (unless already changed)
            if ($materiel->getVendeur() === $this) {
                $materiel->setVendeur(null);
            }
        }
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(User $User): static
    {
        $this->User = $User;

        return $this;
    }
}
