<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductHistory;
use App\Repository\ProductHistoryRepository;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product")
 * @IsGranted("ROLE_ADMIN")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", defaults={"page": "1", "_format"="html", "limit" = "10"}, methods={"GET"}, name="product_index")
     * @Route("/page/{page<[1-9]\d*>}/{limit?}", defaults={"limit" = "10", "_format"="html"}, methods={"GET"}, name="product_index_paginated")
     * @Cache(smaxage="10")
     */
    public function index(Request $request, int $page, int $limit, string $_format, ProductRepository $productRepository, UserRepository $userRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findLatest($page, $limit),
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="product_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $product->setCreatedBy($this->getUser());
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/new.html.twig', [
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
     * @Route("/{id}/edit", name="product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/product_assign_to_user", name="product_assignToUser", methods={"GET","POST"})
     */
    public function productAssignToUser(Request $request, ProductRepository $productRepository, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('assigntoUser', $request->request->get('_token'))) {

            $entityManager = $this->getDoctrine()->getManager();

            // Get Requests
            $userId = $request->request->get('userId');
            $productId = $request->request->get('productId');
            $historyAction = $request->request->get('product_status');
            $customMessage = $request->request->get('custommessage');

            // System message
            $systemMessage = "";

            // If Product not found
            $product = $productRepository->find($productId); 
            if (!$product) {
                $this->addFlash('danger', 'Product not Found');

                return $this->redirectToRoute('product_index');
            }

            if ($historyAction == "assigntouser") {

                // If user is in use database
                $userExist = $userRepository->find($userId);
                if (!$userExist) {
                    $this->addFlash('danger', 'While assigend user Not Found!');
                    
                    return $this->redirectToRoute('product_index'); 
                }

                $userRoom = $userExist->getUserRoom();

                // Assign Product to User
                $product->setAssignToUser($userExist);
                $product->setStatus('inuse');
                $entityManager->persist($product);

                $systemMessage = "Assigned.This product assigned to ".$userExist->getFullName().".Room Number: ".$userRoom;
            } else {
                $systemMessage = $historyAction;
            }

            // Add Product History
            $productHistory = new ProductHistory();
            $productHistory->setProductId($product);
            $productHistory->setCreatedBy($this->getUser());            

            $productHistory->setSystemMessage($systemMessage);
            $productHistory->getCustomMessage($customMessage);

            $entityManager->persist($productHistory);
            $entityManager->flush();

            $this->addFlash("", $systemMessage."|".$customMessage);

            return $this->redirectToRoute('product_index');  
        }

        return $this->redirectToRoute('product_index');
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_index');
    }
}
