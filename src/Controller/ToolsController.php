<?php

namespace App\Controller;

use App\Repository\CityRepository;
use App\Repository\PropertyTypeCategoryRepository;
use App\Repository\RegionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ToolsController extends AbstractController
{
    /**
     * @Route("/regionsJson", name="regionsJson")
     */
    public function regionsJson(RegionRepository $regionRepository)
    {
        return $this->json($regionRepository->findAll(), 200, [], ['groups' => 'region:read']);
    }

    /**
     * @Route("/propertyTypesCategoriesJson", name="propertyTypesCategoriesJson")
     */
    public function propertyTypesCategoriesJson(PropertyTypeCategoryRepository $propertyTypeCategoryRepository)
    {
        return $this->json($propertyTypeCategoryRepository->findAll(), 200, [], ['groups' => 'propertyTypeCategory:read']);
    }
}
