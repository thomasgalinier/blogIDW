<?php

namespace App\Controller;


use App\Entity\Article;
use App\Entity\Commentaire;
use App\Form\CommentairesType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

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
    #[Route('/top/{id}', name: 'app_article')]
    public function article(Request $request,ArticleRepository $articleRepository, Article $article, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $commentaire = new Commentaire();
        $commentaire->setArticle($article);
        $commentaire->setIdUser($user);
        $commentaires = $article->getCommentaires();
        
        $form = $this->createForm(CommentairesType::class, $commentaire);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $commentaire = $form->getData();
            $commentaire->setDate(new \DateTimeImmutable());
            $entityManager->persist($commentaire);
            $entityManager->flush();
            return $this->redirectToRoute('app_article', ['id'=>$article->getId()]);
        }
        

        // $nbCommentaires = $articles->commentaires;
        return $this->render('top/oneArticle.html.twig', [
            'controller_name' => 'TopController',
            'article' => $article,
            'form' => $form,
            'commentaires' =>  $commentaires,
        ]);
    }

    
    #[Route("/like/commentaire/{id}", name: 'app_like_commentaire')]
    public function likeCommentaire(Commentaire $commentaire, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $this->getUser();
        
        if (!$user) {
            return new JsonResponse(['message' => 'Vous devez être connecté pour liker un commentaire.'], Response::HTTP_UNAUTHORIZED);
        }
        
        $utilisateurs = $commentaire->getUtilisateurs();
        
        if ($utilisateurs->contains($user)) {
            $commentaire->removeUtilisateur($user);
            $likedByUser = false;
        } else {
            $commentaire->addUtilisateur($user);
            $likedByUser = true;
        }
    
        $entityManager->flush();
        
        $totalLikes = $commentaire->getUtilisateurs()->count();
    
        return new JsonResponse(['totalLikes' => $totalLikes, 'likedByUser' => $likedByUser]);
    }
    #[Route("/like/article/{id}", name: 'app_like_article')]
    public function likeArticle(Article $article, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $this->getUser();
        
        if (!$user) {
            return new JsonResponse(['message' => 'Vous devez être connecté pour liker un commentaire.'], Response::HTTP_UNAUTHORIZED);
        }
        
        $utilisateurs = $article->getUtilisateurs();
        
        if ($utilisateurs->contains($user)) {
            $article->removeUtilisateur($user);
            $likedByUser = false;
        } else {
            $article->addUtilisateur($user);
            $likedByUser = true;
        }
    
        $entityManager->flush();
        
        $totalLikes = $article->getUtilisateurs()->count();
    
        return new JsonResponse(['totalLikes' => $totalLikes, 'likedByUser' => $likedByUser]);
    }
    

}
