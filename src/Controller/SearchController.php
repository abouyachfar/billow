<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function search(PropertyRepository $propertyRepository, Request $request): Response
    {
        $region = $request->get("region_id", null);
        $city = $request->get("city_id", null);
        $bedrooms = $request->get("bedrooms", null);

        $properties = $propertyRepository->search($region, $city, $bedrooms);

        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
            'properties' => $properties
        ]);
    }
}
