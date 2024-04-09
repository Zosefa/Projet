<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\User;
use App\Entity\Vendeur;
use App\Repository\QuartierRepository;
use App\Repository\UserRepository;
use App\Security\LoginAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'admin.inscription')]
    #[IsGranted('ROLE_ADMIN')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response
    {
        if($request->isMethod('POST')){
            $post=$request->request->all();
            if(isset($post['submit'])){
                $user = new User();
                $password = $post['password'];
                $confirm = $post['confirm'];
                if($password == $confirm){
                    $user->setUsername($post['username'])
                        ->setEmail($post['email'])
                        ->setRoles(['ROLE_ADMIN'])
                        ->setPassword($userPasswordHasher->hashPassword($user,$password))
                        ->setConfirm($userPasswordHasher->hashPassword($user,$confirm));
                    $entityManager->persist($user);
                    $entityManager->flush();
                    return $security->login($user, LoginAuthenticator::class, 'main');
                }else{
                    $this->addFlash('danger','Le mot de Passe et la Confirmation doivent etre le meme');
                    return $this->redirectToRoute('admin.inscription');
                }
            }
        }
        return $this->render('inscription/inscription.html.twig');
    }


    #[Route('/inscription/client', name: 'admin.inscription.client',methods: ['POST','GET'])]
    public function registerclient(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager,UserRepository $userRepository,QuartierRepository $quartier): Response
    {
        $ListeQuartier = $quartier->findAll();
        if($request->isMethod('POST')){
            $post=$request->request->all();
            if(isset($post['submit'])){
                $user = new User();
                $client = new Client();
                $password = $post['password'];
                $confirm = $post['confirm'];
                $username = $post['username'];
                if($password == $confirm){
                    $user->setUsername($post['username'])
                        ->setEmail($post['email'])
                        ->setRoles(['ROLE_CLIENT'])
                        ->setPassword($userPasswordHasher->hashPassword($user,$password))
                        ->setConfirm($userPasswordHasher->hashPassword($user,$confirm));
                    $entityManager->persist($user);
                    $entityManager->flush();
                    $id=$userRepository->getIdentifiant($username);

                    $quartiers = $quartier->find($post['Quartier']);
                    $Users = $userRepository->find($id);
                    $client->setNom($post['Nom'])
                        ->setPrenom($post['Prenom'])
                        ->setAdresse($post['adresse'])
                        ->setTel($post['Tel'])
                        ->setQuartier($quartiers)
                        ->setUser($Users);
                    $entityManager->persist($client);
                    $entityManager->flush();
                    return $security->login($user, LoginAuthenticator::class, 'main');
                }
            }
        }
        return $this->render('inscription/inscriptionClient.html.twig', [
            'Quartier' => $ListeQuartier
        ]);
    }


    #[Route('/inscription/vendeur', name: 'admin.inscription.vendeur')]
    public function registervendeur(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        if($request->isMethod('POST')){
            $post=$request->request->all();
            if(isset($post['submit'])){
                $user = new User();
                $vendeur = new Vendeur();
                $password = $post['password'];
                $confirm = $post['confirm'];
                $username = $post['username'];
                if($password == $confirm){
                    $user->setUsername($post['username'])
                        ->setEmail($post['email'])
                        ->setRoles(['ROLE_VENDEUR'])
                        ->setPassword($userPasswordHasher->hashPassword($user,$password))
                        ->setConfirm($userPasswordHasher->hashPassword($user,$confirm));
                    $entityManager->persist($user);
                    $entityManager->flush();
                    $id=$userRepository->getIdentifiant($username);

                    $Users = $userRepository->find($id);
                    $vendeur->setVendeur($post['Nom'])
                        ->setSiege($post['Siege'])
                        ->setTelE($post['Tel'])
                        ->setUser($Users);
                    $entityManager->persist($vendeur);
                    $entityManager->flush();
                    return $security->login($user, LoginAuthenticator::class, 'main');
                }
            }
        }
        return $this->render('inscription/inscriptionVendeur.html.twig');
    }
}
