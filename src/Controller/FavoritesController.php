<?php

namespace App\Controller;

use App\Repository\BuyPageRepository;
use App\Repository\FavoritesRepository;
use App\Repository\SellPageRepository;
use App\Service\FavoriteService;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoritesController extends AbstractController
{
    /**
     * @Route("/profile/my_favorites", name="my_favorites")
     */
    public function my_favorites(FavoritesRepository $favoritesRepository,
        BuyPageRepository $buyPageRepository,
        SellPageRepository $sellPageRepository): Response
    {
        // Search favorites by user id
        $favorites = $favoritesRepository->findByUser($this->getUser()->getId());

        return $this->render('favorites/index.html.twig', [
            'favorites' => $favorites,
            'has_search' => false,
            'buyPages' => $buyPageRepository->findAll(),
            'sellPages' => $sellPageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/profile/add_favorites", name="add_favorites", methods={"POST"})
     */
    public function add_favorites(Request $request, FavoritesRepository $favoritesRepository, 
        LoggerInterface $logger, FavoriteService $favoriteService
    ) 
    {
        $property_id = $request->get("property_id", null);

        // If the user not connected, do nothing
        if (!$this->getUser()) {
            return $this->json(3, 200, [], []);
        }

        try{
            $exists = $favoritesRepository->exists($property_id, $this->getUser());

            // If Property exists in favorites, do nothing
            if ($exists) {
                return $this->json(-1, 200, [], []); 
            }

            $favoriteService->addToFavorites($this->getUser(), $property_id);
        }catch(Exception $ex){
            $logger->error("[add_favorites] - " . $ex->getMessage());
            return $this->json(0, 500, [], []);
        }

        return $this->json(1, 200, [], []);
    }

    /**
     * @Route("/pofile/favorites/delete", name="remove_favorites")
     */
    public function remove_favorites(Request $request, LoggerInterface $logger, FavoriteService $favoriteService) {
        try{
            // If the user not connected, do nothing
            if (!$this->getUser()) {
                return $this->json(3, 200, [], []);
            }

            $property_id = $request->get("property_id");

            // Remove Property From User Favorites
            $favoriteService->removeFromFavorite($this->getUser()->getId(), $property_id);
        }catch(Exception $ex) {
            $logger->error("[remove_favorites] - " . $ex->getMessage());
            return $this->json(0, 500, [], []);
        }

        return $this->json(1, 200, [], []);
    }
}
