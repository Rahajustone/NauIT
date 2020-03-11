<?php

namespace App\Controller;

use App\Repository\DepartmentRepository;
use App\Repository\ProductRepository;
use App\Repository\ProductTypeRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard")
 * @IsGranted("ROLE_ADMIN")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="dashboard")
     * @param ProductTypeRepository $productTypeRepository
     * @param ProductRepository $productRepository
     * @param DepartmentRepository $departmentRepository
     * @param UserRepository $userRepository
     * @return Response
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function index(ProductTypeRepository $productTypeRepository,
                          ProductRepository $productRepository,
                          DepartmentRepository $departmentRepository,
                          UserRepository $userRepository)
    {
        return $this->render('dashboard/index.html.twig', [
            'productsType' => $productTypeRepository->findAll(),
            'totalProduct' => $productRepository->getTotalProduct(),
            'totalDepartment' => $departmentRepository->getTotalDepartment(),
            'totalUser' => $userRepository->getTotalUser()
        ]);
    }
}
