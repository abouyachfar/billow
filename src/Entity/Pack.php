<?php

namespace App\Entity;

use App\Repository\PackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PackRepository::class)
 */
class Pack
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="pack")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=PackOptions::class, mappedBy="pack", orphanRemoval=true)
     */
    private $packOptions;

    public function __construct()
    {
        $this->packOptions = new ArrayCollection();
        $this->user = new ArrayCollection();
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

    public function setDescription(?string $description): self
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

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setPack($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getPack() === $this) {
                $user->setPack(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * @return Collection<int, PackOptions>
     */
    public function getPackOptions(): Collection
    {
        return $this->packOptions;
    }

    public function addPackOption(PackOptions $packOption): self
    {
        if (!$this->packOptions->contains($packOption)) {
            $this->packOptions[] = $packOption;
            $packOption->setPack($this);
        }

        return $this;
    }

    public function removePackOption(PackOptions $packOption): self
    {
        if ($this->packOptions->removeElement($packOption)) {
            // set the owning side to null (unless already changed)
            if ($packOption->getPack() === $this) {
                $packOption->setPack(null);
            }
        }

        return $this;
    }
}
