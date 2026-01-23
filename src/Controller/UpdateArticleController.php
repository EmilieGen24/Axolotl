<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class UpdateArticleController extends AbstractController
{
    #[Route('/update/article/{id}', name: 'update_article')]
    public function modify(Article $article, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($article);
            $entityManager->flush();
            $this->addFlash('success','Article modifié avec succès !');
            return $this->redirectToRoute('accueil');
        }

        return $this->render('update_article/update_article.html.twig', [
            'articleform' => $form->createView(),
        ]);
    }
}
