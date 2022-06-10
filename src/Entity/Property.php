<?php

namespace App\Entity;

use App\Repository\PropertyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PropertyRepository::class)
 */
class Property
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("property:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("property:read")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups("property:read")
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     * @Groups("property:read")
     */
    private $price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("property:read")
     */
    private $bedrooms;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("property:read")
     */
    private $bathrooms;

    /**
     * @ORM\ManyToOne(targetEntity=Region::class, inversedBy="properties")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("property:read")
     */
    private $region;

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="properties")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("property:read")
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("property:read")
     */
    private $street;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     * @Groups("property:read")
     */
    private $living_space;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     * @Groups("property:read")
     */
    private $lot_dimensions;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("property:read")
     */
    private $level;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("property:read")
     */
    private $half_barth;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Groups("property:read")
     */
    private $reference;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups("property:read")
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity=Picture::class, mappedBy="property", cascade={"all"}, orphanRemoval=true)
     * @Groups("property:read")
     */
    private $pictures;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("property:read")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("property:read")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("property:read")
     */
    private $is_online;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("property:read")
     */
    private $online_from;

    /**
     * @ORM\ManyToOne(targetEntity=PropertyType::class, inversedBy="properties")
     * @Groups("property:read")
     */
    private $PropertyType;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $longitude;

    /**
     * @ORM\OneToMany(targetEntity=Favorites::class, mappedBy="property", cascade={"all"}, orphanRemoval=true)
     */
    private $favorites;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $expired;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $disabledByAdmin;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isFeatured;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
        $this->favorites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getBedrooms(): ?int
    {
        return $this->bedrooms;
    }

    public function setBedrooms(?int $bedrooms): self
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    public function getBathrooms(): ?int
    {
        return $this->bathrooms;
    }

    public function setBathrooms(?int $bathrooms): self
    {
        $this->bathrooms = $bathrooms;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getLivingSpace(): ?string
    {
        return $this->living_space;
    }

    public function setLivingSpace(?string $living_space): self
    {
        $this->living_space = $living_space;

        return $this;
    }

    public function getLotDimensions(): ?string
    {
        return $this->lot_dimensions;
    }

    public function setLotDimensions(?string $lot_dimensions): self
    {
        $this->lot_dimensions = $lot_dimensions;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(?int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getHalfBarth(): ?int
    {
        return $this->half_barth;
    }

    public function setHalfBarth(?int $half_barth): self
    {
        $this->half_barth = $half_barth;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection|Picture[]
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setProperty($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getProperty() === $this) {
                $picture->setProperty(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getIsOnline(): ?bool
    {
        return $this->is_online;
    }

    public function setIsOnline(bool $is_online): self
    {
        $this->is_online = $is_online;

        return $this;
    }

    public function getOnlineFrom(): ?\DateTimeInterface
    {
        return $this->online_from;
    }

    public function setOnlineFrom(\DateTimeInterface $online_from): self
    {
        $this->online_from = $online_from;

        return $this;
    }

    public function getPropertyType(): ?PropertyType
    {
        return $this->PropertyType;
    }

    public function setPropertyType(?PropertyType $PropertyType): self
    {
        $this->PropertyType = $PropertyType;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return Collection|Favorites[]
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Favorites $favorite): self
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites[] = $favorite;
            $favorite->setProperty($this);
        }

        return $this;
    }

    public function removeFavorite(Favorites $favorite): self
    {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getProperty() === $this) {
                $favorite->setProperty(null);
            }
        }

        return $this;
    }

    public function getExpired(): ?bool
    {
        return $this->expired;
    }

    public function setExpired(?bool $expired): self
    {
        $this->expired = $expired;

        return $this;
    }

    public function getDisabledByAdmin(): ?bool
    {
        return $this->disabledByAdmin;
    }

    public function setDisabledByAdmin(?bool $disabledByAdmin): self
    {
        $this->disabledByAdmin = $disabledByAdmin;

        return $this;
    }

    public function getIsFeatured(): ?bool
    {
        return $this->isFeatured;
    }

    public function setIsFeatured(?bool $isFeatured): self
    {
        $this->isFeatured = $isFeatured;

        return $this;
    }
}
