<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LastArticleController extends AbstractController
{
    #[Route('/last/article', name: 'app_last_article')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $articles = $entityManager->getRepository(Article::class)->findAll();

        return $this->render('top/index.html.twig', [
            'controller_name' => 'LastArticleController',
            'articles'=>$articles
        ]);
    }
}
