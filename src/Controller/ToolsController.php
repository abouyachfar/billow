<?php

namespace App\Controller;

use App\Repository\CityRepository;
use App\Repository\PropertyTypeCategoryRepository;
use App\Repository\RegionRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ToolsController extends AbstractController
{
    /**
     * @Route("/regionsJson", name="regionsJson")
     */
    public function regionsJson(Request $request, RegionRepository $regionRepository)
    {
        return $this->json($regionRepository->findAll(), 200, [], ['groups' => 'region:read']);
    }

    /**
     * @Route("/citiesJson", name="citiesJson")
     */
    public function citiesJson(Request $request, CityRepository $cityRepository)
    {
        $key = $request->get("key", null);

        return $this->json($cityRepository->findByKey($key), 200, [], ['groups' => 'city:read']);
    }

    /**
     * @Route("/propertyTypesCategoriesJson", name="propertyTypesCategoriesJson")
     */
    public function propertyTypesCategoriesJson(PropertyTypeCategoryRepository $propertyTypeCategoryRepository)
    {
        return $this->json($propertyTypeCategoryRepository->findAll(), 200, [], ['groups' => 'propertyTypeCategory:read']);
    }

    /**
     * @Route("/citiesByRegionJson", name="citiesByRegionJson")
     */
    public function citiesByRegionJson(Request $request, CityRepository $cityRepository)
    {
        return $this->json($cityRepository->getByRegion($request->get("region_id")), 200, [], ['groups' => 'city:read']);    
    }
}
