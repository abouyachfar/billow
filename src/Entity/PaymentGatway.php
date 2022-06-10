<?php

namespace App\Entity;

use App\Repository\PaymentGatwayRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaymentGatwayRepository::class)
 */
class PaymentGatway
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $slug;

    /**
     * @ORM\Column(type="integer")
     */
    private $env;

    /**
     * @ORM\Column(type="text")
     */
    private $publicKey;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getEnv(): ?int
    {
        return $this->env;
    }

    public function setEnv(int $env): self
    {
        $this->env = $env;

        return $this;
    }

    public function getPublicKey(): ?string
    {
        return $this->publicKey;
    }

    public function setPublicKey(string $publicKey): self
    {
        $this->publicKey = $publicKey;

        return $this;
    }
}
