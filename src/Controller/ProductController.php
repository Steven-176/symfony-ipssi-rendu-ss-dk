<?php

namespace App\Controller;

use DateTimeImmutable;
use App\Entity\Product;
use App\Form\AddCartType;
use App\Form\ProductType;
use App\Form\ProductFilterType;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('', name: 'app_product_index', methods: ['GET', 'POST'])]
    public function index(Request $request, ProductRepository $productRepository): Response
    {
        // dd(['test']);
        $productForm = $this->createForm(ProductFilterType::class);
        $productForm->handleRequest($request);

        if ($productForm->isSubmitted() && $productForm->isValid()) {
            $price = $productForm->get('price')->getData();
            $seller = $productForm->get('seller')->getData();
            $category = $productForm->get('category')->getData();
            $order = $productForm->get('title')->getData();

            if ($seller) {
                $seller = $seller->getId();
            }
            if ($category) {
                $category = $category->getId();
            }

            $products = $productRepository->findByFilterType($price, $seller, $category, $order);
        } else {

            $products = $productRepository->findAll();
        }

        // dd($products);
        
        return $this->render('product/index.html.twig', [
            'products' => $products,
            'productForm' => $productForm->createView(),
            'addCartForm' => $addCartForm->createView()
        ]);
    }

    
    #[Route('product/index/{user}/{product}', name: 'app_cart', methods: ['GET', 'POST'])]
    public function addCart(): Response
    {
        

        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }

    #[Route('/new', name: 'app_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProductRepository $productRepository): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setCreatedAt(new DateTimeImmutable('now'));
            $product->setSeller($user);
            $productRepository->save($product, true);

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show(Request $request, Product $product): Response
    {
        $addCartForm = $this->createForm(AddCartType::class);
        $addCartForm->handleRequest($request);

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'addCartForm' => $addCartForm->createView()
        ]);
    }

    #[Route('/{id}/edit', name: 'app_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->save($product, true);

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product, true);
        }

        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }
}
