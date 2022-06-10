<?php

namespace App\Controller;

use App\Repository\BuyPageRepository;
use App\Repository\SellPageRepository;
use App\Service\UserService;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class AccountSettingsController extends AbstractController
{
    /**
     * @Route("/profile/account/settings", name="account_settings")
     */
    public function index(Request $request, TranslatorInterface $translator, BuyPageRepository $buyPageRepository, 
        SellPageRepository $sellPageRepository, LoggerInterface $logger, UserService $userService): Response
    {
        $errors = array();

        try {
            $submittedToken = $request->request->get('_csrf_token');
            
            if ($this->isCsrfTokenValid('accountSettings', $submittedToken)) {
                $email = $request->get("email");
                $firstName = $request->get("firstName");
                $lastName = $request->get("lastName");
                $tel = $request->get("tel");
                $showPhone = $request->get("showPhone");
                $showEmail = $request->get("showEmail");

                if (empty($email)) {
                    $errors[] = "The filed Email is required!";
                }

                if (empty($firstName)) {
                    $errors[] = "The filed First name is required!";
                }

                if (empty($lastName)) {
                    $errors[] = "The filed Last name is required!";
                }

                if (empty($tel)) {
                    $errors[] = "The filed Tel is required!";
                }

                if (empty($showPhone) && empty($showEmail)) {
                    $errors[] = "You must choose at least one means of contact!";
                }

                if (empty($errors)) {
                    $userService->updateAccountSettings($this->getUser(), $email, $tel, $firstName, $lastName, $showPhone, $showEmail);

                    $this->addFlash('success', $translator->trans('Your informations is saved successfully!'));
                } else {
                    $this->addFlash('error', $translator->trans('Error'));
                }
            }
        } catch (Exception $e) {
            $logger->error("[account_settings] - " . $e->getMessage());
        }

        return $this->render('account_settings/index.html.twig', [
            'errors' => $errors,
            'has_search' => false,
            'buyPages' => $buyPageRepository->findAll(),
            'sellPages' => $sellPageRepository->findAll(),
        ]);
    }
}
