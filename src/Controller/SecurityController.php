<?php

namespace App\Controller;

use App\Form\RegistrationType;
use App\Repository\BuyPageRepository;
use App\Repository\SellPageRepository;
use App\Repository\UserRepository;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Psr\Log\LoggerInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils,
        BuyPageRepository $buyPageRepository,
        SellPageRepository $sellPageRepository): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername, 
            'has_search' => false, 
            'error' => $error,
            'buyPages' => $buyPageRepository->findAll(),
            'sellPages' => $sellPageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request,
        UserService $userService,
        BuyPageRepository $buyPageRepository,
        SellPageRepository $sellPageRepository,
        LoggerInterface $logger): Response
    {
        $token = "";

        try{
            $form = $this->createForm(RegistrationType::class);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Get form data
                $user = $form->getData();
                // Create user on data base
                $userService->registration($user);

                // Prepare success message
                $this->addFlash('success', 'Votre compte est créée en succès!');

                // Redirect to home page
                return $this->redirectToRoute("home");
            }
        } catch(\Exception $e) {
            $logger->error("[app_register] - " . $e->getMessage());
        }
        

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
            'has_search' => false,
            'error' => array(),
            'buyPages' => $buyPageRepository->findAll(),
            'sellPages' => $sellPageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/accountValidation/{token}", name="accountValidation")
     */
    public function accountValidation(Request $request, 
        string $token, 
        UserRepository $userRepository,
        UserService $userService,
        BuyPageRepository $buyPageRepository,
        SellPageRepository $sellPageRepository
    ): Response
    {
        $validated = $userService->accountValidation($token, 1);

        return $this->render('security/accountValidation.html.twig', [
            'has_search' => false,
            'validated' => $validated,
            'buyPages' => $buyPageRepository->findAll(),
            'sellPages' => $sellPageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/forgotPassword", name="forgotPassword")
     */
    public function forgotPassword(Request $request, 
        UserRepository $userRepository,
        UserService $userService,
        SessionInterface $session,
        BuyPageRepository $buyPageRepository,
        SellPageRepository $sellPageRepository): Response
    {
        $errors = array();
        $email = "";
        $code = "";
        $step = $request->get('step') != null ? $request->get('step') : 1;

        if ($step == 1) {
            $email = $request->get("email");
            $return = $userService->forgotPasswordS1($email);

            if ($return == 1) {
                $step = 2;
                $code = "";
            }
        } else if ($step == 2) {
            $code = $request->get('code');
            $email = $request->get('email');
            
            $user = $userRepository->getActivatedUserByEmail($email);
            
            if (!empty($user) && $user->getCode() != $code) {
                $step = 2;
                $errors[] = 'The verification code is invalid!';
            } else {
                $step = 3;
            }
        } else if($step == 3) {
            $email = $request->get("email");
            $code = $session->get('code');

            if ($request->get('password') != $request->get('confirmpassword')) {
                $step = 3;
                $errors[] = "The passwords are different";
            } else {
                $password = $request->get("password");

                $return = $userService->forgotPasswordS3($email, $code, $password);

                if ($return == 0) {
                    $step = 3;
                    $errors[] = "Invalid code!";
                } else {
                    $step = 4;
                }
            }
        }

        return $this->render('security/forgotPassword.html.twig', [
            'has_search' => false,
            'errors' => $errors,
            'email' => $email,
            'code' => $code,
            'step' => $step,
            'buyPages' => $buyPageRepository->findAll(),
            'sellPages' => $sellPageRepository->findAll(),
        ]);
    }
}
