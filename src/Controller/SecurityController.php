<?php

namespace App\Controller;

use App\Form\RegistrationType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
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
    public function register(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $passEncoder): Response
    {
        try{
            $form = $this->createForm(RegistrationType::class);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $user = $form->getData();

                $user->setPassword($passEncoder->encodePassword($user, $form['password']->getData()));
                $user->setEmail($form['email']->getData());
                $user->setRoles(['ROLE_USER']);
                $user->setCreated_at(new DateTime());
                $user->setStatus(1);

                $em->persist($user);
                $em->flush();

                $this->addFlash('success', 'Votre compte est créée en succès!');

                return $this->redirectToRoute("home");
            }
        } catch(\Exception $e) {
            die(var_dump($e->getMessage()));
        }
        

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
            'error' => array()
        ]);
    }
}
