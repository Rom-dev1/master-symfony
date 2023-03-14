<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/post/create', name: 'app_post_create')]
    public function create(EntityManagerInterface $entityManager)
    {
        $post = new Post();
        $post->setName('Fiorella')
             ->setContent('Un super article')
             ->setPublishedAt(new \DateTimeImmutable('now'))
             ->setActive(true);

        $entityManager->persist($post);
        $entityManager->flush();

        return $this->redirectToRoute('app_post');
    }

    #[Route('/post/one', name: 'app_post_one')]
    public function showOne(PostRepository $repository)
    {
        $post = $repository->find(1);

        // SELECT * FROM post WHERE name = 'Fiorella' ORDER BY id DESC LIMIT 1
        $post = $repository->findOneBy(['name' => 'Fiorella'], ['id' => 'DESC']);

        if (!$post) {
            throw $this->createNotFoundException('Attention de bien créer un post Fiorella');
        }

        // Exemple DateTime
        $date = new \DateTimeImmutable();
        dump($date->format('d/m/Y H:i:s'));

        $date = $post->getPublishedAt();
        dump($date->format('d/m/Y H:i:s'));

        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/post/{id}', name: 'app_post_show')]
    public function show(Post $post)
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/post', name: 'app_post')]
    public function index(PostRepository $repository): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $repository->findAll(),
        ]);
    }
}
