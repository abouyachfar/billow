<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;

class CmsService {

    private $em;
    private $logger;

    public function __construct(EntityManagerInterface $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    /**
     * createContact : Creating a contact data on dataBase.
     * 
     * @Param $contact
     * 
     */
    public function createContact($contact)
    {
        try {
            $contact->setCreatedAt(new \DateTime('@'.strtotime('now')));
    
            $this->em->persist($contact);
            $this->em->flush();
        } catch (Exception $e) {
            $this->logger->error("[cms_service] - " . $e->getMessage());
        }
    }
}