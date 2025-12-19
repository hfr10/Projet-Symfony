<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/products')]
class ProductController extends AbstractController
{
    #[Route('', name: 'app_products_list')]
    public function list(EntityManagerInterface $em): Response
    {
        $products = $em->getRepository(Product::class)->findAll();
        return $this->render('product/list.html.twig', ['products' => $products]);
    }

    #[Route('/{id}', name: 'app_product_show')]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', ['product' => $product]);
    }

    #[Route('/create', name: 'app_product_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($request->isMethod('POST')) {
            $product = new Product();
            $product->setName($request->request->get('name'));
            $product->setDescription($request->request->get('description'));
            $product->setPrice($request->request->get('price'));
            $product->setImage($request->request->get('image'));
            $product->setStock($request->request->get('stock'));
            $product->setCreatedAt(new \DateTime());

            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Produit créé !');
            return $this->redirectToRoute('app_products_list');
        }

        return $this->render('product/create.html.twig');
    }

    #[Route('/{id}/edit', name: 'app_product_edit', methods: ['GET', 'POST'])]
    public function edit(Product $product, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($request->isMethod('POST')) {
            $product->setName($request->request->get('name'));
            $product->setDescription($request->request->get('description'));
            $product->setPrice($request->request->get('price'));
            $product->setImage($request->request->get('image'));
            $product->setStock($request->request->get('stock'));
            $product->setUpdatedAt(new \DateTime());

            $em->flush();

            $this->addFlash('success', 'Produit modifié !');
            return $this->redirectToRoute('app_products_list');
        }

        return $this->render('product/edit.html.twig', ['product' => $product]);
    }

    #[Route('/{id}/delete', name: 'app_product_delete', methods: ['POST'])]
    public function delete(Product $product, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $em->remove($product);
        $em->flush();

        $this->addFlash('success', 'Produit supprimé !');
        return $this->redirectToRoute('app_products_list');
    }
}
