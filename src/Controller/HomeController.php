<?php

namespace App\Controller;

use App\Repository\BuyPageRepository;
use App\Repository\SellPageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class HomeController extends AbstractController
{
    /**
     * @Route({"en":"/", "cn":"/"}, name="home")
     */
    public function index($locales, $defaultLocale, BuyPageRepository $buyPageRepository, SellPageRepository $sellPageRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'has_search' => true,
            'buyPages' => $buyPageRepository->findAll(),
            'sellPages' => $sellPageRepository->findAll(),
            'subTitle' => true
        ]);
    }
}
