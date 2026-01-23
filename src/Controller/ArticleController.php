<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ArticleController extends AbstractController
{
    #[Route('/article/{id}', name: 'article')]
    public function index(ArticleRepository $repository): Response
    {
        $articles = $repository->findAll();
        return $this->render('article/article.html.twig', [
            'articles' => $articles,
        ]);
    }

    // pour les commentaires
    #[Route('/article/{id}', name: 'article')]
    public function comment(ArticleRepository $repository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($commentaire);
            $entityManager->flush();
            $this->addFlash('success','Votre commentaire est ajouté avec succès !');
            return $this->redirectToRoute('accueil');
        }

        return $this->render('article/article.html.twig', [
            'articles' => $articles,
            'commentform' => $form->createView(),
        ]);
    }
}
