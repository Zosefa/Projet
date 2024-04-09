<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Commande;
use App\Entity\Materiel;
use App\Entity\Vendeur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterielType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Materiel',TextType::class)
            ->add('Description',TextareaType::class)
            ->add('ImageFile',FileType::class)
            ->add('Prix',MoneyType::class)
            ->add('Categorie', EntityType::class, [
                'class' => Categorie::class,
            'choice_label' => 'categorie',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Materiel::class,
        ]);
    }
}
