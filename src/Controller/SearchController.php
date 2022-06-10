<?php

namespace App\Controller;

use App\Repository\FavoritesRepository;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\BuyPageRepository;
use App\Repository\SellPageRepository;

class SearchController extends AbstractController
{
    /**
     * @Route("/list", name="list", methods={"POST"})
     */
    public function list(Request $request, SessionInterface $session): Response
    {
        $page_name = $request->get("pagename");
        $cities = $request->get("cities", "");
        $bedrooms = $request->get("bedrooms", "");
        $price_min = $request->get("price_min", 0);
        $price_max = $request->get("price_max", "");
        $property_types = $request->get("property_types", "");
        $bathrooms = $request->get("bathrooms", "");
        $living_area_min = $request->get("living_area_min", "");
        $living_area_max = $request->get("living_area_max", "");
        $lot_size_min = $request->get("lot_size_min", "");
        $lot_size_max = $request->get("lot_size_max", "");

        $session->set("cities", $cities);
        $session->set("bedrooms", $bedrooms);
        $session->set("price_min", $price_min);
        $session->set("price_max", $price_max);
        $session->set("property_types", $property_types);
        $session->set("bathrooms", $bathrooms);
        $session->set("living_area_min", $living_area_min);
        $session->set("living_area_max", $living_area_max);
        $session->set("lot_size_min", $lot_size_min);
        $session->set("lot_size_max", $lot_size_max);

        return $this->redirect($page_name);
    }

    /**
     * @Route("/list_result", name="list_result")
     */
    public function list_result(FavoritesRepository $favoritesRepository, 
        PropertyRepository $propertyRepository,
        Request $request, 
        PaginatorInterface $paginatorInterface, 
        SessionInterface $session,
        BuyPageRepository $buyPageRepository,
        SellPageRepository $sellPageRepository)
    {
        $cities = $session->get("cities");
        $bedrooms = $session->get("bedrooms");
        $price_min = $session->get("price_min");
        $price_max = $session->get("price_max");
        $property_types = $session->get("property_types");
        $bathrooms = $session->get("bathrooms");
        $living_area_min = $session->get("living_area_min");
        $living_area_max = $session->get("living_area_max");
        $lot_size_min = $session->get("lot_size_min");
        $lot_size_max = $session->get("lot_size_max");

        $query = $propertyRepository->search($cities, $bedrooms, $price_min, $price_max, $property_types, $bathrooms, $living_area_min, $living_area_max, $lot_size_min, $lot_size_max, true);

        $properties = $paginatorInterface->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            9 /*limit per page*/
        );

        $favorites = array();

        if (!empty($this->getUser())) {
            $favorites = $favoritesRepository->findByUser($this->getUser()->getId());
        }

        $featuredHomesProperties = $propertyRepository->getFeaturedHomes();

        return $this->render('search/list.html.twig', [
            'has_search' => true,
            'properties' => $properties,
            'page_name' => 'list_result',
            'favorites' => $favorites,
            'featuredHomesProperties' => $featuredHomesProperties,
            'buyPages' => $buyPageRepository->findAll(),
            'sellPages' => $sellPageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/map", name="map")
     */
    public function map(PropertyRepository $propertyRepository, 
        Request $request,
        BuyPageRepository $buyPageRepository,
        SellPageRepository $sellPageRepository,
        SessionInterface $session): Response
    {
        /*$cities = $request->get("cities", "");
        $bedrooms = $request->get("bedrooms", "");
        $price_min = $request->get("price_min", 0);
        $price_max = $request->get("price_max", "");
        $property_types = $request->get("property_types", "");
        $bathrooms = $request->get("bathrooms", "");
        $living_area_min = $request->get("living_area_min", "");
        $living_area_max = $request->get("living_area_max", "");
        $lot_size_min = $request->get("lot_size_min", "");
        $lot_size_max = $request->get("lot_size_max", "");*/

        $cities = $session->get("cities");
        $bedrooms = $session->get("bedrooms");
        $price_min = $session->get("price_min");
        $price_max = $session->get("price_max");
        $property_types = $session->get("property_types");
        $bathrooms = $session->get("bathrooms");
        $living_area_min = $session->get("living_area_min");
        $living_area_max = $session->get("living_area_max");
        $lot_size_min = $session->get("lot_size_min");
        $lot_size_max = $session->get("lot_size_max");

        $properties = $propertyRepository->search($cities, $bedrooms, $price_min, $price_max, $property_types, $bathrooms, $living_area_min, $living_area_max, $lot_size_min, $lot_size_max, false);

        return $this->render('search/map.html.twig', [
            'has_search' => true,
            'page_name' => 'map',
            'properties' => $properties,
            'buyPages' => $buyPageRepository->findAll(),
            'sellPages' => $sellPageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/details/{id}/{page_name}", name="details")
     */
    public function details(int $id, string $page_name, 
        PropertyRepository $propertyRepository,
        BuyPageRepository $buyPageRepository, 
        SellPageRepository $sellPageRepository): Response
    {
        $property = $propertyRepository->find($id);

        return $this->render('search/details.html.twig', [
            'has_search' => true,
            'page_name' => $page_name,
            'property' => $property,
            'buyPages' => $buyPageRepository->findAll(),
            'sellPages' => $sellPageRepository->findAll(),
        ]);
    }
}
