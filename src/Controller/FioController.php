<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FioController extends AbstractController
{
    #[Route('/fio', name: 'app_fio')]
    public function index(): Response
    {
        return $this->render('fio/index.html.twig');
    }
}
