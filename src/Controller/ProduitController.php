<?php

namespace App\Controller;

use App\Entity\Materiel;
use App\Form\MaterielType;
use App\Repository\MaterielRepository;
use App\Repository\VendeurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/produit', name: 'app_produit')]
#[IsGranted('ROLE_VENDEUR')]
class ProduitController extends AbstractController
{
    #[Route('/', name: '_liste')]
    public function index(MaterielRepository $repository, VendeurRepository $vendeur): Response
    {
        $user = $this->getUser();
        $idvendeur = $vendeur->getByUser($user);
        $produit = $repository->getByVendeur($idvendeur);
        return $this->render('produit/index.html.twig', [
            'listeProduit' => $produit,
        ]);
    }

    #[Route('/insert', name: '_insert', methods:['POST','GET'])]
    public function insert(Request $request,EntityManagerInterface $em,VendeurRepository $vendeur): Response
    {
        $user = $this->getUser();
        $idvendeur = $vendeur->getByUser($user); 
        $mpivarotra = $vendeur->find($idvendeur);
        $produit = new Materiel();
        $form=$this->createForm(MaterielType::class,$produit);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $produit->setVendeur($mpivarotra);
            $em->persist($produit);
            $em->flush();
            $this->addFlash('success','Produit Enregistrer');
            return $this->redirectToRoute('app_produit_liste');
        }
        return $this->render('produit/insert.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/cryptage/{id}', name: '_cryptage', methods:['POST','GET'], requirements: ['id' => Requirement::DIGITS])]
    public function cryptage(Materiel $materiel){
        $idmateriel = $materiel->getId();
        $chaineAleatoire = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');
        $crypt = $chaineAleatoire.$idmateriel.$chaineAleatoire;
        return $this->redirectToRoute('app_produit_edit',['id' => $crypt]);
    }

    public function decryptage($parametre){
        $decrypt = preg_replace("/[^0-9]/", "", $parametre);
        return $decrypt;
    }

    #[Route('/edit/{id}', name: '_edit', methods:['POST','GET'])]
    public function edit( EntityManagerInterface $em, Request $request, $id, MaterielRepository $repository)
    {
        $decrypt = $this->decryptage($id);
        $data = $repository->find($decrypt);
        $form = $this->createForm(MaterielType::class,$data);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success','Produit Modifer');
            return $this->redirectToRoute('app_produit_liste');
        }
        return $this->render('produit/edit.html.twig',[
            'form' => $form,
            'materiel' => $data
        ]);
    }

    #[Route('/delete/{id}', name: '_delete', methods:['POST','GET'], requirements: ['id' => Requirement::DIGITS])]
    public function delete(Materiel $materiel, EntityManagerInterface $em)
    {
        $em->remove($materiel);
        $em->flush();
        $this->addFlash('danger','Donner Supprimer avec Success');
        return $this->redirectToRoute('app_produit_liste');
    }
}
