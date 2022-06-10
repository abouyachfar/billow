<?php

namespace App\Service;

use App\Entity\Favorites;
use App\Repository\FavoritesRepository;
use App\Repository\PropertyRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;

class FavoriteService 
{
    private $em;
    private $logger;
    private $propertyRepository;
    private $favoritesRepository;

    public function __construct(EntityManagerInterface $em, LoggerInterface $logger, 
        PropertyRepository $propertyRepository, FavoritesRepository $favoritesRepository)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->propertyRepository = $propertyRepository;
        $this->favoritesRepository = $favoritesRepository;
    }

    /**
     * addToFavorites : Add a property on user favorites
     * 
     * @Param $user
     * @Param $property_id
     * 
     */
    public function addToFavorites ($user, $property_id) 
    {
        try{
            // Get property by id
            $property = $this->propertyRepository->find($property_id);

            // Create favorite Entity
            $favorites = new Favorites();
            $favorites->setUser($user);
            $favorites->setProperty($property);
            $favorites->setCreatedAt(new DateTime());

            // Save Favorite Entity in DB
            $this->em->persist($favorites);
            $this->em->flush();
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }

    /**
     * removeFromFavorite : Remove property from user favorites
     * 
     * @Param $user_id
     * @Param $property_id
     */
    public function removeFromFavorite ($user_id, $property_id)
    {
        try {
            // Get favorite by property id and user id
            $favorite = $this->favoritesRepository->findByPropertyAndUser($property_id, $user_id);

            // Remove favorite from DB
            $this->em->remove($favorite);
            $this->em->flush();
        } catch (Exception $e) {
            $this->logger->error("[favorite_service] - " . $e->getMessage());
        }
    }
}