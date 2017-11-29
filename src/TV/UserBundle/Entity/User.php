<?php

namespace TV\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="TV\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255)
     * @Assert\Length(min=2, minMessage="Votre prénom doit faire au moins {{ limit }} caractères.", max=55, maxMessage="Votre prénom ne peut pas passer les {{ limit }} caractères.")
     */
    private $firstName;
    
    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     * @Assert\Length(min=2, minMessage="Votre nom doit faire au moins {{ limit }} caractères.", max=55, maxMessage="Votre nom ne peut pas passer les {{ limit }} caractères.")
     */
    private $lastName;
    
    /**
     * @var string
     *
     * @ORM\Column(name="profession", type="string", length=255)
     * @Assert\Length(min=3, minMessage="Votre profession doit faire au moins {{ limit }} caractères.", max=155, maxMessage="Votre profession ne peut pas passer les {{ limit }} caractères.")
     */
    private $profession;
    
    /**
     * @var string
     *
     * @ORM\Column(name="institution", type="string", length=255)
     * @Assert\Length(min=3, minMessage="Votre institution doit faire au moins {{ limit }} caractères.", max=255, maxMessage="Votre institution ne peut pas passer les {{ limit }} caractères.")
     */
    private $institution;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="registration_date", type="datetime")
     */
    private $registrationDate;
    
    /**
     * @ORM\ManyToMany(targetEntity="TV\CongresBundle\Entity\Congres", inversedBy="registeredMembers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $followedCongresses;
    
    
    
    public function __construct() 
    {
        $this->registrationDate = new \Datetime();
        $this->roles = array('ROLE_USER');
    }
    
    
    
    

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set profession
     *
     * @param string $profession
     *
     * @return User
     */
    public function setProfession($profession)
    {
        $this->profession = $profession;

        return $this;
    }

    /**
     * Get profession
     *
     * @return string
     */
    public function getProfession()
    {
        return $this->profession;
    }

    /**
     * Set institution
     *
     * @param string $institution
     *
     * @return User
     */
    public function setInstitution($institution)
    {
        $this->institution = $institution;

        return $this;
    }

    /**
     * Get institution
     *
     * @return string
     */
    public function getInstitution()
    {
        return $this->institution;
    }

    /**
     * Set registrationDate
     *
     * @param \DateTime $registrationDate
     *
     * @return User
     */
    public function setRegistrationDate($registrationDate)
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    /**
     * Get registrationDate
     *
     * @return \DateTime
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }
    
    /**
     * Add followedCongress
     *
     * @param \TV\CongresBundle\Entity\User $followedCongress
     *
     * @return Congres
     */
    public function addRegistredMember(\TV\CongresBundle\Entity\Congres $followedCongress)
    {
        $this->followedCongresses[] = $followedCongress;
        return $this;
    }

    /**
     * Remove $followedCongress
     *
     * @param \TV\CongresBundle\Entity\User $followedCongress
     */
    public function removeRegistredMember(\TV\CongresBundle\Entity\Congres $followedCongress)
    {
        $this->followedCongresses->removeElement($followedCongress);
    }

    /**
     * Get $followedCongresses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFollowedCongresses()
    {
        return $this->followedCongresses;
    }
}
