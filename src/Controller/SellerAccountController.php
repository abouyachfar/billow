<?php

namespace App\Controller;

use App\Repository\BuyPageRepository;
use App\Repository\PackRepository;
use App\Repository\SellPageRepository;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SellerAccountController extends AbstractController
{
    /**
     * @Route("/profile/seller/account", name="seller_account")
     */
    public function index(BuyPageRepository $buyPageRepository, 
        SellPageRepository $sellPageRepository,
        LoggerInterface $logger): Response
    {
        $packDate = null;
        $pack = null;
        $expired = false;

        try{
            $pack = $this->getUser()->getPack();
            $packDate = $this->getUser()->getPackDate()->format('Y-m-d');
            $expired = $this->isPackValid();
        } catch (Exception $e) {
            $logger->error("[seller_account] - " . $e->getMessage());
        }

        return $this->render('seller_account/index.html.twig', [
            'has_search' => false,
            'pack' => $pack,
            'packDate' => $packDate,
            'expired' => $expired,
            'buyPages' => $buyPageRepository->findAll(),
            'sellPages' => $sellPageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/profile/seller/renewPack", name="renewPack")
     */
    public function renewPack(BuyPageRepository $buyPageRepository, SellPageRepository $sellPageRepository): Response
    {
        $pack = $this->getUser()->getPack();

        return $this->render('seller_account/renew.html.twig', [
            'has_search' => false,
            'pack' => $pack,
            'buyPages' => $buyPageRepository->findAll(),
            'sellPages' => $sellPageRepository->findAll(),
        ]);
    }

    private function isPackValid() {
        $expired = false;

        if ($this->getUser()->getPackDate()->format('Y-m-d H:i:s') < date("Y-m-d H:i:s")) {
            $expired = true;
        }

        return $expired;
    }
}
