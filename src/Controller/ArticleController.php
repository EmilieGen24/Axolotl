<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommentaireRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ArticleController extends AbstractController
{
    // #[Route('/article/{id}', name: 'article')]
    // public function index(ArticleRepository $repository): Response
    // {
    //     $articles = $repository->findAll();
    //     return $this->render('article/article.html.twig', [
    //         'articles' => $articles,
    //     ]);
    // }

    // pour ajouter des commentaires
    #[Route('/article/{id}', name: 'article')]
    
    public function comment(ArticleRepository $repository,Article $articles, Request $request, Security $security, EntityManagerInterface $entityManager): Response
    {
        
        $commentaire = new Commentaire;
        
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $commentaire->setUser($security->getUser());
            $commentaire->setArticle($articles);
            $entityManager->persist($commentaire);
            $entityManager->flush();
            $this->addFlash('success-comment','Votre commentaire est ajouté avec succès !');
            return $this->redirectToRoute('article', ['id' => $articles->getId()]);
        }
        
       
        $articles = $repository->findOneBy(["id"=>$articles->getId()]);
        
        return $this->render('article/article.html.twig', [
            'articles' => $articles,
            'commentform' => $form->createView(),
        ]);
    }

}
