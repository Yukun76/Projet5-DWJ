<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

use App\Entity\Booking;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *      fields= {"email"},
 *      message= "L'email indiqué est déjà utilisé"
 *  )
 * @UniqueEntity(
 *      fields= {"username"},
 *      message= "Le pseudo est déjà utilisé"
 *  )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", max="4096", minMessage="Votre mot de passe doit faire minimum 8 caractères")
     */
    private $password;

    /**
     *@Assert\EqualTo(propertyPath="password", message="Vous n'avez pas tapé le même mot de passe")
     */
    private $repeatPassword;

    /**
     *@Assert\EqualTo(propertyPath="password", message="Vous n'avez pas tapé le même mot de passe")
     */
    public $oldPassword;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @oneToMany(targetEntity="Booking", mappedBy="user")
     */
    private $bookings;

     /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $passwordRequestedAt;

    /**
    * @var string
    *
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    private $token;

    public function __construct()
    {
        $this->roles = array('ROLE_USER');
        $this->bookings = new ArrayCollection();
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getRepeatPassword(): ?string
    {
        return $this->repeatPassword;
    }

    public function setRepeatPassword(string $password): self 
    {
        $this->repeatPassword = $password;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }


    public function getSalt() {
        return null;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function eraseCredentials() {}

    /**
     * @return Booking[]
     */
    public function getBookings() : array
    {
        if ($this->bookings->isEmpty()) {
            return [];
        }

        return $this->bookings->toArray();
    }

    public function addBookings(Booking $booking) : User
    {
        if ($this->bookings->contains($booking)) {
            return $this;
        }

        $this->bookings->add($booking);
        $booking->setUser($this);
        return $this;
    }

    public function __toString() 
    {
        return (string) $this->getUsername(); 
    }

         /*
     * Get passwordRequestedAt
     */
    public function getPasswordRequestedAt()
    {
        return $this->passwordRequestedAt;
    }

    /*
     * Set passwordRequestedAt
     */
    public function setPasswordRequestedAt($passwordRequestedAt)
    {
        $this->passwordRequestedAt = $passwordRequestedAt;
        return $this;
    }

    /*
     * Get token
     */
    public function getToken()
    {
        return $this->token;
    }

    /*
     * Set token
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

}
