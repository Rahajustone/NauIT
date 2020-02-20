<?php

namespace App\Controller;

use App\Entity\ProductModel;
use App\Form\ProductModelType;
use App\Repository\ProductModelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/productmodel")
 */
class ProductModelController extends AbstractController
{
    /**
     * @Route("/", name="productmodel_index", methods={"GET"})
     */
    public function index(ProductModelRepository $productModelRepository): Response
    {
        return $this->render('product_model/index.html.twig', [
            'product_models' => $productModelRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="productmodel_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $productModel = new ProductModel();
        $form = $this->createForm(ProductModelType::class, $productModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $productModel->setCreatedBy($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($productModel);
            $entityManager->flush();

            return $this->redirectToRoute('productmodel_index');
        }

        return $this->render('product_model/new.html.twig', [
            'product_model' => $productModel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="productmodel_show", methods={"GET"})
     */
    public function show(ProductModel $productModel): Response
    {
        return $this->render('product_model/show.html.twig', [
            'product_model' => $productModel,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="productmodel_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProductModel $productModel): Response
    {
        $form = $this->createForm(ProductModelType::class, $productModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productModel->setUpdatedAt(new \DateTime());

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('productmodel_index');
        }

        return $this->render('product_model/edit.html.twig', [
            'product_model' => $productModel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="productmodel_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ProductModel $productModel): Response
    {
        if ($this->isCsrfTokenValid('delete'.$productModel->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($productModel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('productmodel_index');
    }
}
