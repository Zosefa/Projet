<?php

namespace App\Entity;

use App\Repository\MaterielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: MaterielRepository::class)]
#[Vich\Uploadable()]
class Materiel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message : 'Ne peut pas etre vide')]
    #[Assert\Length(min: 5,max:50,minMessage: 'Doit contenir au moin 5 Lettres',maxMessage: 'Ne peut pas depasser plus de 50 caractere')]
    private ?string $Materiel = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message : 'Ne peut pas etre vide')]
    private ?string $Description = null;

    #[ORM\Column(length: 255)]
    #[Assert\Image()]
    private ?string $Photo = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Ne Doit pas etre vide')]
    #[Assert\Positive(message: 'Etre Positive')]
    private ?float $Prix = null;


    #[Vich\UploadableField(mapping: 'materiel',fileNameProperty: 'Photo')]
    #[Assert\Image()]
    private ?File $ImageFile=null;

    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'Materiel')]
    private Collection $commandes;

    #[ORM\ManyToOne(inversedBy: 'materiels')]
    private ?Vendeur $Vendeur = null;

    #[ORM\ManyToOne(inversedBy: 'materiels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $Categorie = null;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getImageFile(): ?File
    {
        return $this->ImageFile;
    }
    public function  setImageFile(?File $ImageFile): static
    {
        $this->ImageFile=$ImageFile;

        return $this;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMateriel(): ?string
    {
        return $this->Materiel;
    }

    public function setMateriel(string $Materiel): static
    {
        $this->Materiel = $Materiel;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->Photo;
    }

    public function setPhoto(string $Photo): static
    {
        $this->Photo = $Photo;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->Prix;
    }

    public function setPrix(float $Prix): static
    {
        $this->Prix = $Prix;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->addMateriel($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            $commande->removeMateriel($this);
        }

        return $this;
    }

    public function getVendeur(): ?Vendeur
    {
        return $this->Vendeur;
    }

    public function setVendeur(?Vendeur $Vendeur): static
    {
        $this->Vendeur = $Vendeur;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->Categorie;
    }

    public function setCategorie(?Categorie $Categorie): static
    {
        $this->Categorie = $Categorie;

        return $this;
    }
}
