<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class GalerieController extends AbstractController
{
    #[Route('/galerie', name: 'galerie')]
    public function index(ArticleRepository $repository): Response
    {
        $articles = $repository->findAll();
        return $this->render('galerie/galerie.html.twig', [
            'articles' => $articles,
        ]);
    }
}
