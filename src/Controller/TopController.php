<?php

namespace App\Controller;


use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TopController extends AbstractController
{
    #[Route('/top', name: 'app_top')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $articles = $entityManager->getRepository(Article::class)->findAll();
        
        
        // $nbCommentaires = $articles->commentaires;
        return $this->render('top/index.html.twig', [
            'controller_name' => 'TopController',
            'articles' => $articles
        ]);
    }
}
