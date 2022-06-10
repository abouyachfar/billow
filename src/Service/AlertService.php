<?php

namespace App\Service;

use App\Entity\Alert;
use App\Repository\AlertRepository;
use App\Repository\CityRepository;
use App\Repository\PropertyTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AlertService {

    private $logger;
    private $session;

    private $alertRepository;
    private $propertyTypeRepository;
    private $cityRepository;
    private $em;

    public function __construct(LoggerInterface $logger, AlertRepository $alertRepository, SessionInterface $session,
        PropertyTypeRepository $propertyTypeRepository, CityRepository $cityRepository, EntityManagerInterface $em)
    {
        $this->logger = $logger;
        $this->alertRepository = $alertRepository;
        $this->session = $session;
        $this->propertyTypeRepository = $propertyTypeRepository;
        $this->cityRepository = $cityRepository;
        $this->em = $em;
    }
    
    /**
     * Get My Alert : Put cretarias in session
     * 
     * @Param $userId
     * 
     */
    public function setMyAlertSession ($userId) 
    {
        try{
            $alert = $this->alertRepository->getByUser($userId);

            $cities = null;
            $citiesObj = null;
            $propertyTypes = null;

            if (!empty($alert)) {
                $citiesObj = $alert->getCities();
                
                foreach($citiesObj as $city) {
                    $cities[] = $city->getId();
                }
        
                foreach($alert->getPropertyType() as $ptopertyType) {
                    $propertyType[] = $ptopertyType->getId();
                }

                $this->session->set("cities", $cities);
                $this->session->set("property_types", $propertyTypes);
                $this->session->set("bedrooms", $alert->getBedrooms());
                $this->session->set("bathrooms", $alert->getBathrooms());
                $this->session->set("price_min", $alert->getPriceMin());
                $this->session->set("price_max", $alert->getPriceMax());
                $this->session->set("living_area_min", $alert->getLivingAreaMin());
                $this->session->set("living_area_max", $alert->getLivingAreaMax());
                $this->session->set("lot_size_min", $alert->getLotSizeMin());
                $this->session->set("lot_size_max", $alert->getLotSizeMax());
            }
        } catch (Exception $e) {
            $this->logger->error("[alert_service] - " . $e->getMessage());
        }
    }

    /**
     * createMyAlert : Creating an alert for a user and saving it in database
     * 
     * @Param $user
     * 
     */
    public function createMyAlert($user)
    {
        try {
            $alert = $this->alertRepository->getByUser($user->getId());

            if (empty($alert)) {
                $alert = new Alert();
            }

            $alert->setUser($user);
            $alert->setPriceMin(intval($this->session->get("price_min")));
            $alert->setPriceMax(intval($this->session->get("price_max")));
            $alert->setBathrooms($this->session->get("bathrooms"));
            $alert->setBedrooms($this->session->get("bedrooms"));
            $alert->setLivingAreaMin(!empty($this->session->get("living_area_min")) ? $this->session->get("living_area_min") : 0);
            $alert->setLivingAreaMax(!empty($this->session->get("living_area_mmax")) ? $this->session->get("living_area_mmax") : 0);
            $alert->setLotSizeMin(!empty($this->session->get("lot_size_min")) ? $this->session->get("lot_size_min") : 0);
            $alert->setLotSizeMax(!empty($this->session->get("lot_size_max")) ? $this->session->get("lot_size_max") : 0);
            $propertyTypes = $this->session->get("property_types");
            $cities = $this->session->get("cities");

            if (!empty($propertyTypes) && is_array($propertyTypes)) {
                for ($i=0; $i<count($propertyTypes); $i++) {
                    $propertyTypeEntity = $this->propertyTypeRepository->find($propertyTypes[$i]);
    
                    if (!empty($propertyTypeEntity)) {
                        $alert->addPropertyType($propertyTypeEntity);
                    }
                }
            }
            
            if (!empty($cities) && is_array($cities)) {
                for ($i=0; $i<count($cities); $i++) {
                    $cityEntity = $this->cityRepository->find($cities[$i]);
    
                    if (!empty($cityEntity)) {
                        $alert->addCity($cityEntity);
                    }
                }
            }

            $this->em->persist($alert);
            $this->em->flush();
        } catch (Exception $e) {
            $this->logger->error("[alert_service] - " . $e->getMessage());
        }
    }
}