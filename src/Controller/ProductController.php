<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product/create', name: 'app_product_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $product->setName('Chaise');
        $product->setPrice(5999);
        $product->setDescription('Un truc pour s\'asseoir...');

        $entityManager->persist($product); // Mets l'objet en attend
        $entityManager->flush(); // INSERT INTO product

        return $this->redirectToRoute('app_product');
    }

    #[Route('/product', name: 'app_product')]
    public function index(ProductRepository $repository)
    {
        $products = $repository->findAll(); // Donne un tableau avec tous les produits de la BDD

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/product/{id}', name: 'app_product_show')]
    public function show($id, ProductRepository $repository)
    {
        // Récupère un produit (ou pas)
        $product = $repository->find($id);

        // 404 si le produit n'existe pas
        if (!$product) {
            throw $this->createNotFoundException();
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }
}
