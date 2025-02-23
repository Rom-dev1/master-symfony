<?php

namespace App\Controller;

<<<<<<< HEAD
use App\Entity\PostCategory;
use App\Form\PostCategoryType;
use App\Repository\PostCategoryRepository;
=======
use App\Entity\Post;
use App\Entity\PostCategory;
use App\Form\PostCategoryType;
use App\Repository\PostCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
>>>>>>> 3893d2fe6a0e0fcdff3757a759844f76ce04bfdf
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/post/category')]
class PostCategoryController extends AbstractController
{
    #[Route('/', name: 'app_post_category_index', methods: ['GET'])]
    public function index(PostCategoryRepository $postCategoryRepository): Response
    {
        return $this->render('post_category/index.html.twig', [
            'post_categories' => $postCategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_post_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PostCategoryRepository $postCategoryRepository): Response
    {
        $postCategory = new PostCategory();
        $form = $this->createForm(PostCategoryType::class, $postCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postCategoryRepository->save($postCategory, true);

            return $this->redirectToRoute('app_post_category_index', [], Response::HTTP_SEE_OTHER);
        }

<<<<<<< HEAD
        return $this->renderForm('post_category/new.html.twig', [
=======
        return $this->render('post_category/new.html.twig', [
>>>>>>> 3893d2fe6a0e0fcdff3757a759844f76ce04bfdf
            'post_category' => $postCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_post_category_show', methods: ['GET'])]
    public function show(PostCategory $postCategory): Response
    {
        return $this->render('post_category/show.html.twig', [
            'post_category' => $postCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_post_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PostCategory $postCategory, PostCategoryRepository $postCategoryRepository): Response
    {
        $form = $this->createForm(PostCategoryType::class, $postCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postCategoryRepository->save($postCategory, true);

            return $this->redirectToRoute('app_post_category_index', [], Response::HTTP_SEE_OTHER);
        }

<<<<<<< HEAD
        return $this->renderForm('post_category/edit.html.twig', [
=======
        return $this->render('post_category/edit.html.twig', [
>>>>>>> 3893d2fe6a0e0fcdff3757a759844f76ce04bfdf
            'post_category' => $postCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_post_category_delete', methods: ['POST'])]
    public function delete(Request $request, PostCategory $postCategory, PostCategoryRepository $postCategoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$postCategory->getId(), $request->request->get('_token'))) {
            $postCategoryRepository->remove($postCategory, true);
        }

        return $this->redirectToRoute('app_post_category_index', [], Response::HTTP_SEE_OTHER);
    }
<<<<<<< HEAD
=======

    #[Route('/new/random', name: 'app_post_category_random')]
    public function newRandom(PostCategoryRepository $repository, EntityManagerInterface $manager)
    {
        // On crée le post
        $post = new Post();
        $post->setName('Un poste');
        $post->setContent('Un contenu');
        $post->setPublishedAt(new \DateTimeImmutable());
        $post->setActive(true);

        // On récupère la catégorie "Catégorie 1" ou on l'a créée
        $postCategory = $repository->findOneBy(['title' => 'Catégorie 1']);

        if (! $postCategory) {
            $postCategory = new PostCategory();
            $postCategory->setTitle('Catégorie 1');
            $manager->persist($postCategory);
        }

        $post->setPostCategory($postCategory);
        $manager->persist($post);
        $manager->flush();

        return $this->redirectToRoute('app_post_category_index');
    }
>>>>>>> 3893d2fe6a0e0fcdff3757a759844f76ce04bfdf
}
