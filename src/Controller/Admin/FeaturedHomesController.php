<?php

namespace App\Controller\Admin;

use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\Types\Boolean;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

class FeaturedHomesController extends AbstractController
{
    /**
     * @Route("/admin/featured/homes", name="app_admin_featured_homes")
     * @IsGranted("ROLE_ADMIN")
     */
    public function app_admin_featured_homes(Request $request, 
        PropertyRepository $propertyRepository, 
        PaginatorInterface $paginatorInterface,
        LoggerInterface $logger): Response
    {
        $featuredHomes = null;

        try {
            $query = $propertyRepository->getFeaturedHomes(1, null, null, null, true);

            $featuredHomes = $paginatorInterface->paginate(
                $query, /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                10 /*limit per page*/
            );
        } catch (Exception $e) {
            $logger->error("[app_admin_featured_homes] - " . $e->getMessage());
        }

        return $this->render('admin/featured_homes/index.html.twig', [
            'featuredHomes' => $featuredHomes,
            'isFeaturedHomes' => 1,
            'owner' => "",
            'property' => "",
            'city' => ""
        ]);
    }

    /**
     * @Route("/admin/searchFeaturedHomes", name="searchFeaturedHomes")
     * @IsGranted("ROLE_ADMIN")
     */
    public function search(Request $request, 
        PropertyRepository $propertyRepository, 
        PaginatorInterface $paginatorInterface,
        LoggerInterface $logger
    ): Response
    {
        $isFeaturedHomes = $request->get("isFeaturedHomes");
        $owner = $request->get("owner");
        $property = $request->get("property");
        $city = $request->get("city");

        $featuredHomes = null;

        try {
            $query = $propertyRepository->getFeaturedHomes($isFeaturedHomes, $owner, $property, $city, true);

            $featuredHomes = $paginatorInterface->paginate(
                $query, /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                10 /*limit per page*/
            );
        } catch (Exception $e) {
            $logger->error("[app_admin_featured_homes] - " . $e->getMessage());
        }

        return $this->render('admin/featured_homes/index.html.twig', [
            'featuredHomes' => $featuredHomes,
            'isFeaturedHomes' => $isFeaturedHomes,
            'owner' => $owner,
            'property' => $property,
            'city' => $city
        ]);
    }

    /**
     * @Route("/admin/setFeaturedHome", name="setFeaturedHome")
     * @IsGranted("ROLE_ADMIN")
     */
    public function setFeaturedHome(Request $request, 
        PropertyRepository $propertyRepository,
        EntityManagerInterface $em,
        LoggerInterface $logger)
    {
        $propertyId = $request->get("property_id");
        $value = $request->get("value");

        $property = $propertyRepository->find($propertyId);

        if (!empty($property)) {
            $property->setIsFeatured(filter_var($value, FILTER_VALIDATE_BOOLEAN));
        
            $em->persist($property);
            $em->flush();
        } else {
            $logger->info("[setFeaturedHome] - Not Found (" . $propertyId . ")");
            return $this->json(1, 404, [], []);    
        }

        return $this->json(1, 200, [], []);
    }
}
