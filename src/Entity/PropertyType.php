<?php

namespace App\Entity;

use App\Repository\PropertyTypeRepository;
use Doctrine\ORM\Mapping as ORM;
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
}
