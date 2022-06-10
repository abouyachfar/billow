<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService {

    private $logger;
    private $em;
    private $passEncoder;
    private $router;
    private $userRepository;
    private $session;

    public function __construct(LoggerInterface $logger, EntityManagerInterface $em, 
        UserPasswordEncoderInterface $passEncoder, RouterInterface $router,
        UserRepository $userRepository, SessionInterface $session) {
        $this->logger = $logger;
        $this->em = $em;
        $this->passEncoder = $passEncoder;
        $this->router = $router;
        $this->userRepository = $userRepository;
        $this->session = $session;
    }

    /**
     * updateAccountSettings : Update user data
     * 
     * @Param $user
     * @Param $email
     * @Param $tel
     * @Param $firstName
     * @Param $lastName
     * 
     */
    public function updateAccountSettings($user, $email, $tel, $firstName, $lastName, $showPhone, $showEmail) 
    {
        try{
            $user->setEmail($email);
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setTel($tel);
            $showPhone === 'on' ? $user->setShowPhone(true) : $user->setShowPhone(false);
            $showEmail === 'on' ? $user->setShowEmail(true) : $user->setShowEmail(false);

            $this->em->persist($user);
            $this->em->flush();
        } catch (Exception $e) {
            $this->logger->error("[user_service] - " . $e->getMessage());
        }
    }

    public function registration($user) {
        try {
            $cleanPassword = $user->getPassword();
            $token = uniqid("TKNBW_yu", true) . time();
            $user->setPassword($this->passEncoder->encodePassword($user, $user->getPassword()));
            $user->setRoles(['ROLE_USER']);
            $user->setCreated_at(new DateTime());
            $user->setStatus(0);
            $user->setToken($token);
            $user->setShowPhone(0);
            $user->setShowEmail(1);

            $this->em->persist($user);
            $this->em->flush();

            // Send Verification Email
            // oprtsdnatyronzok
            $transport = Transport::fromDsn('gmail+smtp://billowhelpdesk%40gmail.com:pszfwdngyldlixaj@default?encryption=tls&auth_mode=plan&verify_peer=0');
            $mailer = new Mailer($transport);
            $url = $this->router->generate("accountValidation", array("token" => $token), UrlGeneratorInterface::ABSOLUTE_URL);

            $html = "<div style='text-align: center;padding: 40px 20px;background: rgb(239, 239, 239);'>";
            $html .= "<p style='text-align: center'><a href='http://www.billow.ca'><img style='width: 200px;margin-left: -35px;' src='http://billow.ca/img/logo.png'></p>";
            $html .= "<h1>Welcome " . $user->getEmail() . "!</h1>";
            $html .= "<p style='margin: 0;'>Thank you for signing up for Billow.ca!</p>";
            $html .= "<p style='margin: 0;'><h3><u>Your account details :</u></h3><b>Username: </b>" . $user->getEmail() . "<br/><b>Password: </b>" . $cleanPassword . "</p>";
            $html .= "<p style='margin: 0;'>Please verify your email address by clicking the button below.</p>";
            $html .= "<p style='margin: 40px 0px;'><a href='" . $url . "' style='text-decoration: none;border:none;padding: 12px 15px;font-size: 20px;border-radius:5px;color:#fff;background:#006cfa;font-weight:400'>Confirm my account</a></p>";
            $html .= "<p style='margin: 0;'>Please note that unverified accounts are automatically deleted in 30 days after sign up.</p>";
            $html .= "<p style='margin: 0;'>If you didn't request this, please ignore this email.</p>";
            
            $html .= "<br/>";
            $html .= "<hr/>";
            $html .= "<br/>";

            $html .= "<p style='margin: 0;'>Yours, Billow Team</p>";
            $html .= "<p style='margin: 0;'><b>Email:</b> <a href='#'>billowhelpdesk@gmail.com</a></p>";
            $html .= "<p style='margin: 0;'><b>Phone:</b> <a href='#'>778-522-9888</a></p>";
            $html .= "</div>";

            // Send Email
            $email = (new Email())
                    ->from('contact@billow.ca')
                    ->to($user->getEmail())
                    ->subject('Billow - Email Verification')
                    ->text('')
                    ->html($html);

            $mailer->send($email);
        } catch (Exception $e) {
            $this->logger->error("[user_service] - " . $e->getMessage());
        }
    }

    public function accountValidation($token, $status) {
        $validated = false;

        try {
            $user = $this->userRepository->getByToken($token);

            if (!empty($user)) {
                $user->setStatus($status);
                $user->setToken("");
                $this->em->persist($user);
                $this->em->flush();

                $validated = true;
            }
        } catch (Exception $e) {
            $this->logger->error("[user_service] - " . $e->getMessage());
            $validated = false;
        }

        return $validated;
    }

    public function forgotPasswordS1($email) {
        $return = 0;

        try {
            $token = uniqid("TKNBW_yu", true) . time();
            $code = rand(100, 900) . rand(100, 900);

            $this->session->set('code', $code);

            $user = $this->userRepository->getActivatedUserByEmail($email);

            if (!empty($user)) {
                $user->setCode($code);
                $this->em->persist($user);
                $this->em->flush();

                // Send Verification Email
                $transport = Transport::fromDsn('gmail+smtp://billowhelpdesk%40gmail.com:pszfwdngyldlixaj@default?encryption=tls&auth_mode=plan&verify_peer=0');
                $mailer = new Mailer($transport);
                $url = $this->router->generate("accountValidation", array("token" => $token), UrlGeneratorInterface::ABSOLUTE_URL);

                $html = "<div style='text-align: center;padding: 40px 20px;background: rgb(239, 239, 239);'>";
                $html .= "<p style='text-align: center'><a href='http://www.billow.ca'><img style='width: 200px;margin-left: -35px;' src='http://billow.ca/img/logo.png'></p>";
                $html .= "<h3>Hi " . $email . "!</h3>";
                $html .= "<p style='margin: 0;'>We received a password reset request for your Billow account.</p>";
                $html .= "<p style='margin: 0;'>" . $code . "<h3></h3></p>";
                $html .= "<p style='margin: 0;'>Enter this code to complete the reset.</p>";
                $html .= "<p style='margin: 0;'>If you didn't request this, please ignore this email.</p>";
                
                $html .= "<br/>";
                $html .= "<hr/>";
                $html .= "<br/>";

                $html .= "<p style='margin: 0;'>Yours, Billow Team</p>";
                $html .= "<p style='margin: 0;'><b>Email:</b> <a href='#'>billowhelpdesk@gmail.com</a></p>";
                $html .= "<p style='margin: 0;'><b>Phone:</b> <a href='#'>778-522-9888</a></p>";
                $html .= "</div>";

                // Send Email
                $emailSend = (new Email())
                        ->from('contact@billow.ca')
                        ->to($email)
                        ->subject('Billow - Forgot Password')
                        ->html($html);

                $mailer->send($emailSend);

                $return = 1;
            }
        } catch (Exception $e) {
            $this->logger->error("[user_service] - " . $e->getMessage());
            $return = 0;
        }

        return $return;
    }

    public function forgotPasswordS3($email, $code, $password) {
        $return = 0;

        try {
            $user = $this->userRepository->getActivatedUserByEmail($email);

            if (!empty($user) && $user->getCode() == $code) {
                $user->setPassword($this->passEncoder->encodePassword($user, $password));
                $user->setCode(null);
                $this->em->persist($user);
                $this->em->flush();

                $return = 1;
            } else {
                $return = 0;
            }
        } catch (Exception $e) {
            $this->logger->error("[user_service] - " . $e->getMessage());
            $return = 0;
        }

        return $return;
    }
}