<?php

namespace App\Controller;

use App\Entity\Payment;
use App\Repository\BuyPageRepository;
use App\Repository\PackRepository;
use App\Repository\SellPageRepository;
use App\Repository\UserRepository;
use App\Service\PaymentService;
use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    /**
     * @Route("/goPayment/{packId}", name="goPayment")
     */
    public function goPayment(int $packId, BuyPageRepository $buyPageRepository, 
        SellPageRepository $sellPageRepository, PaymentService $paymentService): Response
    {
        $pack = null;
        $userObj = null;
        
        // If user is connected, get user data and pack to do payment
        if (!empty($this->getUser())) {
            $userObj = $paymentService->prepareUser($packId, $this->getUser());
        }

        return $this->render('payment/index.html.twig', [
            'has_search' => false,
            'pack' => $userObj["pack"],
            'userObj' => $userObj["user"],
            'buyPages' => $buyPageRepository->findAll(),
            'sellPages' => $sellPageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/doPayment", name="doPayment")
     */
    public function doPayment(Request $request, PackRepository $packRepository, PaymentService $paymentService, 
        BuyPageRepository $buyPageRepository, SellPageRepository $sellPageRepository): Response
    {
        $packId = $request->get("pack_id");
        $name = $request->get('stripe_nom');
        $email = $request->get('stripe_email');
        $token = $request->get('stripeToken');

        $charge = $paymentService->doPayment($packId, $this->getUser(), $name, $email, $token);

        return $this->render('payment/payment_result.html.twig', [
            'has_search' => false,
            'charge' => $charge,
            'buyPages' => $buyPageRepository->findAll(),
            'sellPages' => $sellPageRepository->findAll(),
        ]);
    }
}
