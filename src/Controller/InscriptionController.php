<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'inscription')]
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordEncoder): Response
    {
        $user = new User();
        $userform = $this->createForm(UserType::class, $user);
        $userform->handleRequest($request);
        if ($userform->isSubmitted() && $userform->isValid()){
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($passwordEncoder->hashPassword($user, $userform->get('password')->getData()));
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success','Votre compte a été créé avec succès !');
            return $this->redirectToRoute('accueil');
        }
        return $this->render('inscription/inscription.html.twig', [
            'userform' =>$userform->createView(),
        ]);
    }
}
