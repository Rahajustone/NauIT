<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\ProductTypeRepository;
use App\Repository\ProductModelRepository;
use App\Repository\ProductHistoryRepository;
use App\Repository\UserRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportsController extends AbstractController
{
    /**
     * @Route("/reports", name="reports")
     */
    public function index( ProductRepository $productRepository, ProductTypeRepository $productTypeRepository, ProductModelRepository $productModelRepository, UserRepository $userRepository, Request $request
    )
    {
        if ($request->isMethod('GET')) {
            $productsId = $request->query->get("products");
            $devicesTypeId = $request->query->get("devicetypes");
            $productModelsId = $request->query->get("productmodels");
            $usersId = $request->query->get("users");
            $ipAddress = $request->query->get("ipaddress");
            $minPrice = $request->query->get("minprice");
            $maxPrice = $request->query->get("maxprice");
            $serialNumber = $request->query->get("serialnumber");

            $productsResult = $productRepository->search($productsId, $devicesTypeId, $productModelsId, $usersId, $ipAddress, $minPrice, $maxPrice, $serialNumber);
        }

        return $this->render('reports/index.html.twig', [
            "products" => $productRepository->findAll(),
            "devicesType" => $productTypeRepository->findAll(),
            "productsModel" => $productModelRepository->findAll(),
            "users" => $userRepository->findAll(),
            "productsResult" => $productsResult 
        ]);
    }

    /**
     * @Route("/getReportResult", name="getReportResult")
    */
   public function getReportResult(Request $request, ProductRepository $productRepository)
   {

        $productsId = $request->query->get("products");
        $devicesTypeId = $request->query->get("devicetypes");
        $productModelsId = $request->query->get("productmodels");
        $usersId = $request->query->get("users");
        $ipAddress = $request->query->get("ipaddress");
        $minPrice = $request->query->get("minprice");
        $maxPrice = $request->query->get("maxprice");
        $serialNumber = $request->query->get("serialnumber");

        $result = $productRepository->search($productsId, $devicesTypeId, $productModelsId, $usersId, $ipAddress, $minPrice, $maxPrice, $serialNumber);


         // TODO


   }
    
}
