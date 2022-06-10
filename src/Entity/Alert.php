<?php

namespace App\Entity;

use App\Repository\AlertRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AlertRepository::class)
 */
class Alert
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $priceMin;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $priceMax;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $bedrooms;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $bathrooms;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $livingAreaMin;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $livingAreaMax;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $lotSizeMin;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $lotSizeMax;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=PropertyType::class, inversedBy="alerts", fetch="EAGER")
     */
    private $PropertyType;

    /**
     * @ORM\ManyToMany(targetEntity=City::class)
     */
    private $cities;

    public function __construct()
    {
        $this->PropertyType = new ArrayCollection();
        $this->cities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPriceMin(): ?string
    {
        return $this->priceMin;
    }

    public function setPriceMin(?string $priceMin): self
    {
        $this->priceMin = $priceMin;

        return $this;
    }

    public function getPriceMax(): ?string
    {
        return $this->priceMax;
    }

    public function setPriceMax(?string $priceMax): self
    {
        $this->priceMax = $priceMax;

        return $this;
    }

    public function getBedrooms(): ?string
    {
        return $this->bedrooms;
    }

    public function setBedrooms(?string $bedrooms): self
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    public function getBathrooms(): ?string
    {
        return $this->bathrooms;
    }

    public function setBathrooms(?string $bathrooms): self
    {
        $this->bathrooms = $bathrooms;

        return $this;
    }

    public function getLivingAreaMin(): ?int
    {
        return $this->livingAreaMin;
    }

    public function setLivingAreaMin(?int $livingAreaMin): self
    {
        $this->livingAreaMin = $livingAreaMin;

        return $this;
    }

    public function getLivingAreaMax(): ?int
    {
        return $this->livingAreaMax;
    }

    public function setLivingAreaMax(?int $livingAreaMax): self
    {
        $this->livingAreaMax = $livingAreaMax;

        return $this;
    }

    public function getLotSizeMin(): ?int
    {
        return $this->lotSizeMin;
    }

    public function setLotSizeMin(?int $lotSizeMin): self
    {
        $this->lotSizeMin = $lotSizeMin;

        return $this;
    }

    public function getLotSizeMax(): ?int
    {
        return $this->lotSizeMax;
    }

    public function setLotSizeMax(?int $lotSizeMax): self
    {
        $this->lotSizeMax = $lotSizeMax;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|PropertyType[]
     */
    public function getPropertyType(): Collection
    {
        return $this->PropertyType;
    }

    public function addPropertyType(PropertyType $propertyType): self
    {
        if (!$this->PropertyType->contains($propertyType)) {
            $this->PropertyType[] = $propertyType;
        }

        return $this;
    }

    public function removePropertyType(PropertyType $propertyType): self
    {
        $this->PropertyType->removeElement($propertyType);

        return $this;
    }

    /**
     * @return Collection|City[]
     */
    public function getCities(): Collection
    {
        return $this->cities;
    }

    public function addCity(City $city): self
    {
        if (!$this->cities->contains($city)) {
            $this->cities[] = $city;
        }

        return $this;
    }

    public function removeCity(City $city): self
    {
        $this->cities->removeElement($city);

        return $this;
    }
}
