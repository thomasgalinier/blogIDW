<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LastArticleController extends AbstractController
{
    #[Route('/last/article', name: 'app_last_article')]
    public function index(): Response
    {
        return $this->render('last_article/index.html.twig', [
            'controller_name' => 'LastArticleController',
        ]);
    }
}
