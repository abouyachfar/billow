<?php

namespace App\Controller;

use App\Entity\Alert;
use App\Entity\PropertyType;
use App\Repository\AlertRepository;
use App\Repository\CityRepository;
use App\Repository\PropertyTypeRepository;
use App\Service\AlertService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AlertController extends AbstractController
{
    private $alertService;
    private $logger;

    public function __construct(AlertService $alertService, LoggerInterface $logger)
    {
        $this->alertService = $alertService;
        $this->logger = $logger;
    }

    /**
     * @Route("/profile/my_alert", name="my_alert")
     */
    public function my_alert(): Response
    {
        try{
            $this->alertService->setMyAlertSession($this->getUser()->getId());
        }catch(Exception $e) {
            $this->logger->error("[my_alerts] - " . $e->getMessage());
        }

        return $this->redirect($this->generateUrl('list_result'));
    }

    /**
     * @Route("/profile/create_my_alert", name="create_my_alert")
     */
    public function create_my_alert()
    {
        try{
            $this->alertService->createMyAlert($this->getUser());
        } catch (Exception $e) {
            $this->logger->error("[create_my_alert] - " . $e->getMessage());
        }

        return $this->json(1, 200, [], []);
    }
}
