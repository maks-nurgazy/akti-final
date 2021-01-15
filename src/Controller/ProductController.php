<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/products")
 */
class ProductController extends AbstractController
{


    /**
     * @Route("/", name="product_list", methods={"GET"})
     */
    public function index(ProductRepository $productRepository): Response
    {

        $products = $productRepository->findAll();

        return $this->render('product/index.html.twig', ['products' => $products]);
    }


    /**
     * @Route("/create", name="create_product", methods={"GET","POST"})
     */
    public function createProduct(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            $CrMsg = 'Create new product completed successfully!';
            $this->addFlash('info', $CrMsg);

            return $this->redirectToRoute('product_list');
        }

        return $this->render('product/create.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }


    /**
     * @Route("/update/{id}", name="product_update",methods={"GET","POST"})
     */
    public function update(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        $UpId = $request->get('id');
        $UpMsg = 'Update on ID: ' . $UpId . ' completed successfully!';

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('info', $UpMsg);

            return $this->redirectToRoute('product_list');
        }

        return $this->render('product/update.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/product/search/{name}")
     */
    public function search(Request $request, string $name, ProductRepository $productRepository): Response
    {

        $minPrice = 1000;
        $value = $request->query->get('q');

//        $products = $productRepository->findAllGreaterThanPrice($minPrice);
        $products = $productRepository->findLike($name, $value);

        if (!$products) {
            return new Response('Nothing found');
        }

//        return new Response('Check out this great product: '.$name);
        return new Response('Check out this great product: ' . $products[0]->getName());
    }


    /**
     * @Route("/{id}", name="product_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $DeId = $request->get('id');
            $DeMsg = 'Delete on ID: ' . $DeId . ' completed successfully!';
            $entityManager->remove($product);
            $entityManager->flush();
            $this->addFlash('info', $DeMsg);
        }

        return $this->redirectToRoute('product_list');
    }


}
