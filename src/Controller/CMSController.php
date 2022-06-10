<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\BuyPageRepository;
use App\Repository\FaqRepository;
use App\Repository\PackRepository;
use App\Repository\SellPageRepository;
use App\Service\CmsService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class CMSController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request,
        TranslatorInterface $translator,
        BuyPageRepository $buyPageRepository, 
        SellPageRepository $sellPageRepository,
        LoggerInterface $logger,
        CmsService $cmsService): Response
    {
        $errors = array();

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        $submittedToken = $request->request->get('token');

        try{
            if ($this->isCsrfTokenValid('send-contact', $submittedToken)) {
                $cmsService->createContact($form->getData());
                
                $this->addFlash('success', $translator->trans('Your message is saved successfully!'));
    
                return $this->redirectToRoute("contact");
            } else if ($form->getErrors()) {
                $errors = $form->getErrors();
            }
        }catch(Exception $e) {
            $this->addFlash('error', $translator->trans('Sorry, A problem has occurred, please try again later!'));
            $errors = $form->getErrors();
            $logger->error("[contact] - " . $e->getMessage());
        }

        return $this->render('cms/contact.html.twig', [
            'contactForm' => $form->createView(),
            'has_search' => false,
            'error' => $errors,
            'buyPages' => $buyPageRepository->findAll(),
            'sellPages' => $sellPageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/faq", name="faq")
     */
    public function faq(FaqRepository $faqRepository, BuyPageRepository $buyPageRepository, SellPageRepository $sellPageRepository): Response
    {
        $faq = $faqRepository->findAll();

        return $this->render('cms/faq.html.twig', [
            'has_search' => false,
            'faq' => $faq,
            'buyPages' => $buyPageRepository->findAll(),
            'sellPages' => $sellPageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/pricing", name="pricing")
     */
    public function pricing(PackRepository $packRepository, 
        BuyPageRepository $buyPageRepository, 
        SellPageRepository $sellPageRepository): Response
    {
        $packs = $packRepository->findAll();

        return $this->render('cms/pricing.html.twig', [
            'has_search' => false,
            'packs' => $packs,
            'buyPages' => $buyPageRepository->findAll(),
            'sellPages' => $sellPageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/sell/{id}", name="sell")
     */
    public function sell(int $id, BuyPageRepository $buyPageRepository, SellPageRepository $sellPageRepository): Response
    {
        $sellPage = $sellPageRepository->find($id);

        return $this->render('cms/sell.html.twig', [
            'has_search' => false,
            'buyPages' => $buyPageRepository->findAll(),
            'sellPages' => $sellPageRepository->findAll(),
            'sellPage' => $sellPage,
        ]);
    }

    /**
     * @Route("/buy/{id}", name="buy")
     */
    public function buy(int $id, BuyPageRepository $buyPageRepository, SellPageRepository $sellPageRepository): Response
    {
        $buyPage = $buyPageRepository->find($id);

        return $this->render('cms/buy.html.twig', [
            'has_search' => false,
            'buyPages' => $buyPageRepository->findAll(),
            'sellPages' => $sellPageRepository->findAll(),
            'buyPage' => $buyPage,
        ]);
    }
}
