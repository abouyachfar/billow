<?php

namespace App\Entity;

use App\Repository\PropertyTypeCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PropertyTypeCategoryRepository::class)
 */
class PropertyTypeCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("propertyTypeCategory:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("propertyTypeCategory:read")
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity=PropertyType::class, mappedBy="propertyType")
     * @Groups("propertyTypeCategory:read")
     */
    private $propertyTypes;

    public function __construct()
    {
        $this->propertyTypes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection|PropertyType[]
     */
    public function getPropertyTypes(): Collection
    {
        return $this->propertyTypes;
    }

    public function addPropertyType(PropertyType $propertyType): self
    {
        if (!$this->propertyTypes->contains($propertyType)) {
            $this->propertyTypes[] = $propertyType;
            $propertyType->setPropertyType($this);
        }

        return $this;
    }

    public function removePropertyType(PropertyType $propertyType): self
    {
        if ($this->propertyTypes->removeElement($propertyType)) {
            // set the owning side to null (unless already changed)
            if ($propertyType->getPropertyType() === $this) {
                $propertyType->setPropertyType(null);
            }
        }

        return $this;
    }
}
