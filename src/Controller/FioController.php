<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;

class FioController extends AbstractController
{
    #[Route('/fio', name: 'app_fio')]
    public function index(): Response
    {
        return $this->render('fio/index.html.twig');
    }

    #[Route('/fio/create', name: 'app_fio_create', methods: ['POST'])]
    public function create(Request $request)
    {
        $form = $this->createFormBuilder(null, ['csrf_protection' => false])
            ->add('name', null, [
                'constraints' => [new NotBlank()]
            ])->getForm();
        $form->submit(json_decode($request->getContent(), true));

        if (!$form->isValid()) {
            $errors = [];

            foreach ($form->getErrors(true) as $error) {
                $errors[$error->getOrigin()->getName()] = $error->getMessage();
            }

            return $this->json($errors, 422);
        }

        return $this->json([
            'message' => 'Merci '.$form->getData()['name'].' !',
        ]);
    }
}
