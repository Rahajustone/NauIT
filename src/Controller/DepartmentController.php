<?php

namespace App\Controller;

use App\Entity\Department;
use App\Form\DepartmentType;
use App\Repository\DepartmentRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

/**
 * @Route("/department")
 */
class DepartmentController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("/", defaults={"page": "1", "_format"="html", "limit" = "10"}, methods={"GET"}, name="department_index")
     * @Route("/page/{page<[1-9]\d*>}/{limit?}", defaults={"limit" = "10", "_format"="html"}, methods={"GET"}, name="department_index_paginated")
     * @Cache(smaxage="10")
     */
    public function index(Request $request, int $page, int $limit, string $_format, DepartmentRepository $departmentRepository): Response
    {
        return $this->render('department/index.html.twig', [
            'departments' => $departmentRepository->findLatest($page, $limit),
        ]);
    }

    /**
     * @Route("/new", name="department_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $department = new Department();
        $form = $this->createForm(DepartmentType::class, $department);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $department->setCreatedBy($this->getUser());

            // TODO
            //$this->logger->info("Created Department");

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($department);
            $entityManager->flush();

            return $this->redirectToRoute('department_index');
        }

        return $this->render('department/new.html.twig', [
            'department' => $department,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="department_show", methods={"GET"})
     */
    public function show(Department $department): Response
    {
        return $this->render('department/show.html.twig', [
            'department' => $department,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="department_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Department $department): Response
    {
        $form = $this->createForm(DepartmentType::class, $department);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $department->setUpdatedAt(new \Datetime());

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('department_index');
        }

        return $this->render('department/edit.html.twig', [
            'department' => $department,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="department_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Department $department): Response
    {
        if ($this->isCsrfTokenValid('delete'.$department->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($department);
            $entityManager->flush();
        }

        return $this->redirectToRoute('department_index');
    }
}
