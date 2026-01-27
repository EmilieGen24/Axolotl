<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class AddArticleController extends AbstractController
{
    #[Route('/add/article', name: 'add_article')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($article);
            $entityManager->flush();
            $this->addFlash('success-add','Votre article est ajouté avec succès !');
            return $this->redirectToRoute('galerie');
        }

        return $this->render('add_article/add_article.html.twig', [
            'articleform' => $form->createView(),
        ]);
    }
}
