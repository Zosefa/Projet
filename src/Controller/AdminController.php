<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use App\Repository\MaterielRepository;
use App\Repository\UserRepository;
use App\Repository\VendeurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin', name: 'admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(UserRepository $user): Response
    {
        return $this->render('admin/admin.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/client', name: '_client')]
    public function client(ClientRepository $client): Response
    {
        $data = $client->findAll();

        return $this->render('admin/client/client.html.twig', [
            'data' => $data,
        ]);
    }

    #[Route('/vendeur', name: '_vendeur')]
    public function vendeur(VendeurRepository $vendeur): Response
    {
        $data = $vendeur->findAll();
        return $this->render('admin/vendeur/vendeur.html.twig', [
            'data' => $data,
        ]);
    }

    #[Route('/produit', name: '_produit')]
    public function produit(MaterielRepository $produit): Response
    {
        $data = $produit->findAll();
        return $this->render('admin/materiel/materiel.html.twig', [
            'data' => $data,
        ]);
    }
}
