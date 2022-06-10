<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(
 *  fields={"email"},
 *  message="Account already exists with this login"
 * )
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups("property:read")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\Length(min="6", minMessage="Votre mot de passe doit contenir 6 caractères")
     * @Assert\EqualTo(propertyPath="confirm_password", message="Les mots de passes sont différents")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="Les mots de passes sont différents")
     */
    private $confirm_password;

    /**
     * @var string A "Y-m-d H:i:s" formatted value
     * @ORM\Column(type="datetime")
     * @Assert\DateTime
     */
    private $created_at;

    /**
     * @var integer The status
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("property:read")
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("property:read")
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Groups("property:read")
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\OneToMany(targetEntity=Favorites::class, mappedBy="user", cascade={"all"}, orphanRemoval=true)
     */
    private $favorites;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity=Pack::class, inversedBy="user")
     */
    private $pack;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $packDate;

    /**
     * @ORM\OneToMany(targetEntity=Payment::class, mappedBy="user", orphanRemoval=true, cascade={"all"}, orphanRemoval=true)
     */
    private $payments;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $showPhone;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $showEmail;

    public function __construct()
    {
        $this->favorites = new ArrayCollection();
        $this->payments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirm_password;
    }

    public function setConfirmPassword(string $confirm_password): self
    {
        $this->confirm_password = $confirm_password;

        return $this;
    }

    /**
     * Get a "Y-m-d H:i:s" formatted value
     *
     * @return  string
     */ 
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Set a "Y-m-d H:i:s" formatted value
     *
     * @param  string  $created_at  A "Y-m-d H:i:s" formatted value
     *
     * @return  self
     */ 
    public function setCreated_at(DateTime $created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(?string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(?string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

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
            $favorite->setUser($this);
        }

        return $this;
    }

    public function removeFavorite(Favorites $favorite): self
    {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getUser() === $this) {
                $favorite->setUser(null);
            }
        }

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(?int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getPack(): ?Pack
    {
        return $this->pack;
    }

    public function setPack(?Pack $pack): self
    {
        $this->pack = $pack;

        return $this;
    }

    public function getPackDate(): ?\DateTimeInterface
    {
        return $this->packDate;
    }

    public function setPackDate(?\DateTimeInterface $packDate): self
    {
        $this->packDate = $packDate;

        return $this;
    }

    public function __toString()
    {
        return (!empty($this->getFirstName()) && !empty($this->getLastName())) ? $this->getFirstName() . ' ' . $this->getLastName() : $this->getEmail();
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): self
    {
        if (!$this->payments->contains($payment)) {
            $this->payments[] = $payment;
            $payment->setUser($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): self
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getUser() === $this) {
                $payment->setUser(null);
            }
        }

        return $this;
    }

    public function getShowPhone(): ?bool
    {
        return $this->showPhone;
    }

    public function setShowPhone(?bool $showPhone): self
    {
        $this->showPhone = $showPhone;

        return $this;
    }

    public function getShowEmail(): ?bool
    {
        return $this->showEmail;
    }

    public function setShowEmail(?bool $showEmail): self
    {
        $this->showEmail = $showEmail;

        return $this;
    }
}
