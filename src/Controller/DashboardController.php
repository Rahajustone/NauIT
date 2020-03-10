<?php

namespace App\Controller;

use App\Repository\ProductTypeRepository;
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
     * @param $a
     * @return Response
     */
    public function index(ProductTypeRepository $productTypeRepository)
    {
        return $this->render('dashboard/index.html.twig', [
            'productsType' => $productTypeRepository->findAll()
        ]);
    }
}
