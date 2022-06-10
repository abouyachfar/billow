<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Entity\Property;
use App\Repository\CityRepository;
use App\Repository\FavoritesRepository;
use App\Repository\PictureRepository;
use App\Repository\PropertyRepository;
use App\Repository\PropertyTypeRepository;
use App\Repository\RegionRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Repository\BuyPageRepository;
use App\Repository\SellPageRepository;
use Psr\Log\LoggerInterface;

class PropertyController extends AbstractController
{
    /**
     * @Route("/profile/property/myListing", name="myListing")
     */
    public function myListing(Request $request, FavoritesRepository $favoritesRepository, 
        PropertyRepository $propertyRepository, PaginatorInterface $paginatorInterface,
        BuyPageRepository $buyPageRepository, SellPageRepository $sellPageRepository): Response
    {
        if ($this->isPackValid()) {
            return $this->redirectToRoute("seller_account");
        }

        $query = $propertyRepository->getByOwner($this->getUser()->getId(), true);

        $properties = $paginatorInterface->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            9 /*limit per page*/
        );

        $favorites = array();

        if (!empty($this->getUser())) {
            $favorites = $favoritesRepository->findByUser($this->getUser()->getId());
        }

        return $this->render('property/index.html.twig', [
            'has_search' => false,
            'properties' => $properties,
            'favorites' => $favorites,
            'buyPages' => $buyPageRepository->findAll(),
            'sellPages' => $sellPageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/profile/property/{id}", name="property", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function property(int $id, PropertyRepository $propertyRepository, 
        RegionRepository $regionRepository, CityRepository $cityRepository,
        PropertyTypeRepository $propertyTypeRepository,
        BuyPageRepository $buyPageRepository, SellPageRepository $sellPageRepository): Response
    {
        if ($this->isPackValid()) {
            return $this->redirectToRoute("seller_account");
        }

        $property = $propertyRepository->find($id);
        $regions = $regionRepository->findAll();
        $cities = $cityRepository->getByRegion($property->getRegion()->getId());
        $propertyType = $propertyTypeRepository->findAll();

        return $this->render('property/property.html.twig', [
            'has_search' => false,
            'property' => $property,
            'regions' => $regions,
            'cities' => $cities,
            'propertyType' => $propertyType,
            'buyPages' => $buyPageRepository->findAll(),
            'sellPages' => $sellPageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/profile/property/save", name="saveProperty", methods={"POST"})
     */
    public function saveProperty(Request $request, TranslatorInterface $translator, 
        PropertyRepository $propertyRepository, EntityManagerInterface $em, 
        PropertyTypeRepository $propertyTypeRepository, RegionRepository $regionRepository,
        CityRepository $cityRepository, BuyPageRepository $buyPageRepository, SellPageRepository $sellPageRepository,
        LoggerInterface $logger)
    {
        $errorMessages = array();
        $property = null;

        try {
            if ($this->isPackValid()) {
                return $this->redirectToRoute("seller_account");
            }

            $id = $request->get("id");
            $title = $request->get("title");
            $description = $request->get("description");
            $region = $request->get("region");
            $city = $request->get("city");
            $propertyType = $request->get("propertytype");
            $price = $request->get("price");
            $bedrooms = !empty($request->get("bedrooms")) ? $request->get("bedrooms") : null;
            $bathrooms = $request->get("bathrooms") ? $request->get("bathrooms") : null;
            $street = $request->get("street");
            $livingspace = $request->get("livingspace") ? $request->get("livingspace") : null;
            $lotdimensions = $request->get("lotdimensions") ? $request->get("lotdimensions") : null;
            $level = $request->get("level") ? $request->get("level") : null;
            $longitude = $request->get("longitude") ? $request->get("longitude") : null;
            $latitude = $request->get("latitude") ? $request->get("latitude") : null;

            if (!empty($id)) {
                $property = $propertyRepository->find($id);
                $property->setUpdatedAt(new DateTime());
            } else {
                $property = new Property();
                $property->setOwner($this->getUser());
                $property->setCreatedAt(new DateTime());
                $property->setIsOnline(0);
                $property->setDisabledByAdmin(0);
                $property->setExpired(0);
                $property->setIsFeatured(0);
                $ref = "BI-" . rand(1000, 9000) . rand(1000, 9000);
                $property->setReference($ref);
            }

            if (!$this->getUser()) {
                $errorMessages[] = $translator->trans("You should be authentified!");
            }

            if (empty($title)) {
                $errorMessages[] = $translator->trans("Title is requiered!");
            }

            if (empty($description)) {
                $errorMessages[] = $translator->trans("Description is requiered!");
            }

            if (empty($propertyType)) {
                $errorMessages[] = $translator->trans("Property type is requiered!");
            }

            if (empty($price)) {
                $errorMessages[] = $translator->trans("Price is requiered!");
            }

            if (empty($region)) {
                $errorMessages[] = $translator->trans("Region is requiered!");
            }

            if (empty($city)) {
                $errorMessages[] = $translator->trans("City is requiered!");
            }

            if (empty($street)) {
                $errorMessages[] = $translator->trans("Street is requiered!");
            }

            if (empty($errorMessages) && !empty($property) && $property->getOwner()->getId() == $this->getUser()->getId()) {
                $property->setTitle($title);
                $property->setDescription($description);
                $property->setRegion($regionRepository->find($region));
                $property->setCity($cityRepository->find($city));
                $property->setPropertyType($propertyTypeRepository->find($propertyType));
                $property->setPrice($price);
                $property->setBedrooms($bedrooms);
                $property->setBathrooms($bathrooms);
                $property->setStreet($street);
                $property->setLivingSpace($livingspace);
                $property->setLotDimensions($lotdimensions);
                $property->setLevel($level);

                $property->setLatitude($latitude);
                $property->setLongitude($longitude);

                $em->persist($property);
                $em->flush();

                $this->uploadFiles($_FILES, $property, $em, $logger);
            }    
        } catch (Exception $ex) {
            $logger->error("[saveProperty] - " . $ex->getMessage());
            $this->addFlash('error', $translator->trans('Error Server'));
        }

        if (!empty($errorMessages)) {
            $this->addFlash('errorMessages', $errorMessages);

            $regions = $regionRepository->findAll();
            $cities = $cityRepository->getByRegion($region);
            $propertyType = $propertyTypeRepository->findAll();

            if (!empty($id)) {
                return $this->render('property/property.html.twig', [
                    'has_search' => false,
                    'property' => $property,
                    'regions' => $regions,
                    'cities' => $cities,
                    'propertyType' => $propertyType,
                    'errorMessages' => $errorMessages,
                    'buyPages' => $buyPageRepository->findAll(),
                    'sellPages' => $sellPageRepository->findAll(),
                ]);
            } else {
                return $this->render('property/new.html.twig', [
                    'controller_name' => 'PropertyController',
                    'has_search' => false,
                    'property' => $property,
                    'regions' => $regions,
                    'cities' => $cities,
                    'propertyType' => $propertyType,
                    'errorMessages' => $errorMessages,
                    'buyPages' => $buyPageRepository->findAll(),
                    'sellPages' => $sellPageRepository->findAll(),
                ]);
            }
            
        } else {
            $this->addFlash('success', $translator->trans('Your property is saved successfully!')); 
            return $this->redirectToRoute("myListing");
        }  
    }

    /**
     * @Route("/profile/property/enable/{id}", name="enableProperty")
     */
    public function enableProperty(int $id, PropertyRepository $propertyRepository, 
        EntityManagerInterface $em, TranslatorInterface $translator, LoggerInterface $logger)
    {
        try {
            if ($this->isPackValid()) {
                return $this->redirectToRoute("seller_account");
            }

            $property = $propertyRepository->find($id);

            if (!empty($property) && $property->getOwner()->getId() == $this->getUser()->getId()) {
                $property->setIsOnline(1);
                $property->setOnlineFrom(new Datetime());

                $em->persist($property);
                $em->flush();
            }

            $this->addFlash('success', $translator->trans('Your property is enabled successfully!'));
        } catch (Exception $ex) {
            $logger->error("[enableProperty] - " . $ex->getMessage());
            $this->addFlash('error', $translator->trans('Error Server'));
        }

        return $this->redirectToRoute("myListing");
    }

    /**
     * @Route("/profile/property/disable/{id}", name="disableProperty")
     */
    public function disableProperty(int $id, PropertyRepository $propertyRepository, 
        EntityManagerInterface $em, TranslatorInterface $translator,
        LoggerInterface $logger)
    {
        try {
            if ($this->isPackValid()) {
                return $this->redirectToRoute("seller_account");
            }

            $property = $propertyRepository->find($id);

            if (!empty($property) && $property->getOwner()->getId() == $this->getUser()->getId()) {
                $property->setIsOnline(0);
                $property->setOnlineFrom(new Datetime());

                $em->persist($property);
                $em->flush();
            }

            $this->addFlash('success', $translator->trans('Your property is disabled successfully!'));
        } catch (Exception $ex) {
            $logger->error("[disableProperty] - " . $ex->getMessage());
            $this->addFlash('error', $translator->trans('Error Server!'));
        }

        return $this->redirectToRoute("myListing");
    }

    /**
     * @Route("/profile/property/new", name="newProperty")
     */
    public function newProperty(RegionRepository $regionRepository, CityRepository $cityRepository,
        PropertyTypeRepository $propertyTypeRepository, BuyPageRepository $buyPageRepository, SellPageRepository $sellPageRepository): Response
    {
        if ($this->isPackValid()) {
            return $this->redirectToRoute("seller_account");
        }

        $regions = $regionRepository->findAll();
        $cities = $cityRepository->findAll();
        $propertyType = $propertyTypeRepository->findAll();

        return $this->render('property/new.html.twig', [
            'has_search' => false,
            'regions' => $regions,
            'cities' => $cities,
            'propertyType' => $propertyType,
            'buyPages' => $buyPageRepository->findAll(),
            'sellPages' => $sellPageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/profile/property/delete", name="deleteProperty", methods={"POST"})
     */
    public function deleteProperty(Request $request, EntityManagerInterface $em, 
        PropertyRepository $propertyRepository, TranslatorInterface $translator, LoggerInterface $logger)
    {
        try{
            if ($this->isPackValid()) {
                return $this->redirectToRoute("seller_account");
            }

            $id = $request->get("id", null);

            if (!empty($id)) {
                $property = $propertyRepository->find($id);

                if (!empty($property) && $property->getOwner()->getId() == $this->getUser()->getId()) {
                    $em->remove($property);
                    $em->flush();
                }
            }

            $this->addFlash('success', $translator->trans('Your property is deleted successfully!'));
        } catch (Exception $ex){
            $logger->error("[deleteProperty] - " . $ex->getMessage());
            $this->addFlash('error', $translator->trans('Error Server!'));
        }

        return $this->redirectToRoute("myListing");
    }

    private function uploadFiles($files, $property, $em, $logger) 
    {
        try{
            $target_dir = $this->getParameter('property_full_directory');

            $i=1;
            foreach ($files as $file) {
                $ext = strtolower(pathinfo($file["name"],PATHINFO_EXTENSION));

                if (in_array($ext, ["jpg", "JPG", "png", "PNG", "gif", "Gif", "jpeg", "JPEG"])) {
                    $name_file = "img_".$property->getId()."_".uniqid().".".$ext;
                    $url = $this->getParameter('property_directory') . $name_file;
                    $target_file = $target_dir . $name_file;

                    move_uploaded_file($file["tmp_name"], $target_file);                    

                    $propertyPicture = new Picture();
                    $propertyPicture->setUrl($url);
                    $propertyPicture->setProperty($property);

                    if ( $i == 1) {
                        $propertyPicture->setIsCover(true);
                    } else {
                        $propertyPicture->setIsCover(false);
                    }
                    
                    $em->persist($propertyPicture);
                    $em->flush();

                    $i++;
                }
            }
        } catch (Exception $ex) {
            $logger->error("[delete property picture] - " . $ex->getMessage());
        }
    }

    /**
     * @Route("/profile/property/delete_picture", name="delete_picture", methods={"POST"})
     */
    public function delete_picture(Request $request, 
        PictureRepository $pictureRepository,
        EntityManagerInterface $em,
        LoggerInterface $logger
    ){
        try{
            if ($this->isPackValid()) {
                return $this->redirectToRoute("seller_account");
            }
            
            $picture = $pictureRepository->find($request->get("picture_id"));
            $property = $picture->getProperty();

            if (!empty($picture) && $property->getOwner()->getId() == $this->getUser()->getId()) {
                $em->remove($picture);
                $em->flush();
            }
        } catch (Exception $ex) {
            $logger->error("[delete_picture] - " . $ex->getMessage());
            return $this->json(0, 500, [], []);
        }

        return $this->json(1, 200, [], []);
    }

    private function isPackValid() {
        $expired = false;

        if ($this->getUser()->getPackDate() != null && $this->getUser()->getPackDate()->format('Y-m-d H:i:s') < date("Y-m-d H:i:s")) {
            $expired = true;
        }

        return $expired;
    }

    private function getCoordonnees($region, $city, $street) {
        $text = $street . "," . $region->getLabel() . ".json";
        $params = $text . "?language=fr&access_token=sk.eyJ1IjoiYWJvdXlhY2hmYXIiLCJhIjoiY2t6azIzc2k0MGM5ZjJ1bnowb3dod3d4YiJ9.GU0AVkLTkYscMAf_PBOq_Q";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.mapbox.com/geocoding/v5/mapbox.places/" . $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        // On récupere les coordonnées qui correspendent au text
        $response = json_decode($response);

        // On récupere le longitude et latitude
        $longitude = $response->features[0]->center[0];
        $latitude = $response->features[0]->center[1];        

        return ["longitude" => $longitude, "latitude" => $latitude];
    }

    /**
     * @Route("/seacheAddressesJSON", name="seacheAddressesJSON")
     */
    public function seacheAddressesJSON(Request $request, PropertyRepository $propertyRepository, LoggerInterface $logger)
    {
        $text =$request->get("text");
        $properties = $propertyRepository->getByAddress($text);
        return $this->json($properties, 200, [], ['groups' => 'property:read']);    
    }
}
