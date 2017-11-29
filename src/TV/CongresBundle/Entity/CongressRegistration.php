<?php

namespace TV\CongresBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CongressRegistration
 *
 * @ORM\Table(name="congress_registration")
 * @ORM\Entity(repositoryClass="TV\CongresBundle\Repository\CongressRegistrationRepository")
 */
class CongressRegistration
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\OneToOne(targetEntity="TV\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    
    /**
     * @ORM\ManyToOne(targetEntity="TV\CongresBundle\Entity\Congres", inversedBy="registredMembers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $congres;
    
    /**
     * @var string
     *
     * @ORM\Column(name="chosen_day", type="string", length=255)
     */
    private $chosenDay;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="event", type="boolean")
     */
    private $event;
    
    /**
     * @var int
     *
     * @ORM\Column(name="total_amount", type="integer", nullable=true)
     */
    private $totalAmount;
    
    


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set chosenDay
     *
     * @param string $chosenDay
     *
     * @return CongressRegistration
     */
    public function setChosenDay($chosenDay)
    {
        $this->chosenDay = $chosenDay;

        return $this;
    }

    /**
     * Get chosenDay
     *
     * @return string
     */
    public function getChosenDay()
    {
        return $this->chosenDay;
    }

    /**
     * Set event
     *
     * @param boolean $event
     *
     * @return CongressRegistration
     */
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return boolean
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set user
     *
     * @param \TV\UserBundle\Entity\User $user
     *
     * @return CongressRegistration
     */
    public function setUser(\TV\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \TV\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * Set congres
     *
     * @param \TV\CongresBundle\Entity\Congres $congres
     *
     * @return CongressRegistration
     */
    public function setCongres(\TV\CongresBundle\Entity\Congres $congres)
    {
        $this->congres = $congres;

        return $this;
    }

    /**
     * Get congres
     *
     * @return \TV\CongresBundle\Entity\Congres
     */
    public function getCongres()
    {
        return $this->congres;
    }
    
    /**
     * Get totalAmount
     *
     * @return int
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * Set totalAmount
     *
     * @param integer $totalAmount
     *
     * @return Register
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }
}
