<?php

namespace App\Entity;

use App\Repository\PropertyTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PropertyTypeRepository::class)
 */
class PropertyType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("propertyTypeCategory:read")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=PropertyTypeCategory::class, inversedBy="propertyTypes")
     */
    private $propertyType;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("propertyTypeCategory:read")
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity=Property::class, mappedBy="PropertyType")
     */
    private $properties;

    public function __construct()
    {
        $this->properties = new ArrayCollection();
        $this->alerts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPropertyType(): ?PropertyTypeCategory
    {
        return $this->propertyType;
    }

    public function setPropertyType(?PropertyTypeCategory $propertyType): self
    {
        $this->propertyType = $propertyType;

        return $this;
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
     * @return Collection|Property[]
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function addProperty(Property $property): self
    {
        if (!$this->properties->contains($property)) {
            $this->properties[] = $property;
            $property->setPropertyType($this);
        }

        return $this;
    }

    public function removeProperty(Property $property): self
    {
        if ($this->properties->removeElement($property)) {
            // set the owning side to null (unless already changed)
            if ($property->getPropertyType() === $this) {
                $property->setPropertyType(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getLabel();
    }
}
