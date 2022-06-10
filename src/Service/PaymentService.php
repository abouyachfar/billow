<?php

namespace App\Service;

use App\Entity\Payment;
use App\Repository\PackRepository;
use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;

class PaymentService
{
    private $paymentPK = "pk_live_51KnCsWI2MZWReosk5xnF2Z3KFhhYYTEGJd2TErAdwWxOaQtD4YqBe5Q7OifRmiu6XsNHMCDRuifucSdEHiZ7HzOp00cjcVNhsH";
    private $paymentSK = "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";
    /*private $paymentPK = "pk_live_51KnCsWI2MZWReosk5xnF2Z3KFhhYYTEGJd2TErAdwWxOaQtD4YqBe5Q7OifRmiu6XsNHMCDRuifucSdEHiZ7HzOp00cjcVNhsH";
    private $paymentSK = "sk_test_51JfAdhJcebqSZWTLXjhTl4w60Yy6LRNMSQGegCgmEu8APK7NaTOfrlCVHoOFZYAxCHKvnCmrd8gk6FU7ru2tpEPg000ojysq2n";*/
    private $customerURL = "https://api.stripe.com/v1/customers";
    private $chargeURL = "https://api.stripe.com/v1/charges";

    private $logger; 
    private $em;
    private $packRepository;

    public function __construct(LoggerInterface $logger, PackRepository $packRepository, EntityManagerInterface $em)
    {
        $this->logger = $logger;
        $this->em = $em;
        $this->packRepository = $packRepository;
    }

    /**
     * getPaymentPK
     * 
     * return string
     */
    public function getPaymentPK()
    {
        return $this->paymentPK;
    }

    /**
     * getPaymentSK
     * 
     * return string
     */
    public function getPaymentSK()
    {
        return $this->paymentSK;
    }

    /**
     * prepareUser : Prepare user and pack schema to send to front
     * 
     * @Param $packId
     * @Param $user
     */
    public function prepareUser($packId, $user)
    {
        $userObj = null;

        try {
            $pack = $this->packRepository->find($packId);

            $userObj = array();
            $userObj["token"] = $this->getPaymentPK();
            $userObj["name"] = $user->getFirstName() . " " . $user->getLastName();
            $userObj["email"] = $user->getEmail();
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return ["user" => $userObj, "pack" => $pack];
    }

    /**
     * doPayment : Do all process of payment and call to stripe API
     * 
     * @Param $packId
     * @Param $user
     * @Param $name
     * @Param $email
     * @Param $token
     * 
     * return chargObject
     */
    public function doPayment($packId, $user, $name, $email, $token)
    {
        $charge = null;

        try {
            // Search pack on DB
            $pack = $this->packRepository->find($packId);

            // If pack exists continue, if else do nothing
            if (!empty($pack)) {
                // Create customer
                $ch = curl_init();

                $data = [
                    'source' => $token,
                    'description' => $name,
                    'email' => $email
                ];

                curl_setopt_array($ch, [
                        CURLOPT_URL => $this->customerURL,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_USERPWD => ($this->paymentSK),
                        CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
                        CURLOPT_POSTFIELDS => http_build_query($data)
                    ]
                );

                // Execute Stripe API call to create a customer
                $customer = json_decode(curl_exec($ch));

                curl_close($ch);

                // Create Payment for the customer
                $ch = curl_init();

                $data = [
                    'amount' => $pack->getPrice() * 100,
                    'currency' => 'eur',
                    'customer' => $customer->id
                ];

                $charge = curl_setopt_array($ch, [
                        CURLOPT_URL => $this->chargeURL,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_USERPWD => ($this->paymentSK),
                        CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
                        CURLOPT_POSTFIELDS => http_build_query($data)
                    ] 
                );

                // Execute Stripe API call to create customer payment
                $charge = json_decode(curl_exec($ch));

                curl_close($ch);

                // Create Payment Entity for saving
                $payment = new Payment();
                $payment->setUser($user);
                $payment->setPrice($charge->amount / 100);
                $payment->setStatus($charge->status);
                $payment->setPaymentDate(new DateTime());
                $payment->setPack($pack);
                
                if (!empty($charge->failure_message)) {
                    $payment->setMessage($charge->failure_message);
                }

                if (!empty($charge->payment_method_details)
                    && !empty($charge->payment_method_details->card)) 
                {
                    $payment->setCard($charge->payment_method_details->card->brand);
                }

                // Save payment on DB
                $this->em->persist($payment);
                $this->em->flush();

                // Update pack in User Entity
                $user = $user;
                $user->setPack($pack);

                // Calcule number of days to keep
                $dt = $user->getPackDate();
                $later = $dt;
                $earlier = new DateTime();
                $diff = $later->diff($earlier)->format("%r%a");

                // We initialize the pack date with now datetime
                $dt = new DateTime();

                // If diff is > 0, we add the diff to the pack date initialized
                if ($diff > 0) {
                    $dt->add(new DateInterval('P'.$diff.'D'));
                }

                // We add 6 months to the pack date calculated
                $dt->add(new DateInterval('P6M'));

                $user->setPackDate(new DateTime($dt->format('Y-m-d H:i:s')));

                // Save user in DB
                $this->em->persist($user);
                $this->em->flush();
            }
        } catch (Exception $e) {
            $this->logger->error("[payment_service] - " . $e->getMessage());
        }
        
        return $charge;
    }
}