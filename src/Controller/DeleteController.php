<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class DeleteController extends AbstractController
{
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Article $article, Request $request, EntityManagerInterface $entityManager): Response
    {
         if($this->isCsrfTokenValid("SUP". $article->getId(),$request->get('_token'))){
            $entityManager->remove($article);
            $entityManager->flush();
            $this->addFlash("success","La suppression a été effectuée !");
            return $this->redirectToRoute("accueil");
        }
    }
}