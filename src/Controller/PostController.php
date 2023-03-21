<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PostController extends AbstractController
{
    #[Route('/article/nouveau', name: 'app_post_new')]
    public function new(Request $request, EntityManagerInterface $entityManager)
    {
        $post = new Post();
        $post->setPublishedAt(new \DateTimeImmutable());
        $post->setActive(true);

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('app_post');
        }

        return $this->render('post/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/article/modifier/{id}', name: 'app_post_edit')]
    public function edit(Post $post, Request $request, EntityManagerInterface $entityManager)
    {
        // $post = $entityManager->getRepository(Post::class)->find($id);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('app_post');
        }

        return $this->render('post/edit.html.twig', [
            'form' => $form,
            'post' => $post,
        ]);
    }

    #[Route('/article/supprimer/{id}', name: 'app_post_delete')]
    public function delete(Post $post, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($post);
        $entityManager->flush();

        return $this->redirectToRoute('app_post');
    }

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
    public function index(Request $request, PostRepository $repository, ValidatorInterface $validator): Response
    {
        $date = $request->get('date'); // ?date=2023-10-15

        // OPTIONNEL Vérifier que la date est correcte
        // La passer à la vue dans le value du input
        $errors = $validator->validate($date, [
            new Date()
        ]);

        if (count($errors) > 0) {
            $date = date('Y-m-d'); // 2023-03-15
        }

        return $this->render('post/index.html.twig', [
            // SELECT * FROM post
            // 'posts' => $repository->findAll(),
            // SELECT * FROM post WHERE active = 1
            // 'posts' => $repository->findBy(['active' => true]),
            'posts' => $repository->findAllActives($date),
            'date' => $date,
        ]);
    }
}
