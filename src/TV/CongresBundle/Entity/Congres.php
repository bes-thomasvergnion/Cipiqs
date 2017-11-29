<?php

namespace TV\CongresBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Congres
 *
 * @ORM\Table(name="congres")
 * @ORM\Entity(repositoryClass="TV\CongresBundle\Repository\CongresRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Congres
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
     * @var \DateTime
     *
     * @ORM\Column(name="publication_date", type="datetime")
     * @Assert\DateTime()
     */
    private $publicationDate;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     * @Assert\DateTime()
     */
    protected $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\Length(min=10, minMessage="Le titre doit faire au moins {{ limit }} caractères.", max=255, maxMessage="Le titre ne peut pas passer les {{ limit }} caractères.")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="localisation", type="string", length=255)
     * @Assert\Length(min=3, minMessage="Le titre doit faire au moins {{ limit }} caractères.", max=255, maxMessage="Le titre ne peut pas passer les {{ limit }} caractères.")
     */
    private $localisation;

    /**
     * @ORM\ManyToOne(targetEntity="TV\CongresBundle\Entity\Pdf", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     * @Assert\Valid
     */
    private $preProgram;

    /**
     * @ORM\ManyToOne(targetEntity="TV\CongresBundle\Entity\Pdf", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     * @Assert\Valid
     */
    private $summary;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;
    
    /**
     * @ORM\ManyToOne(targetEntity="TV\CongresBundle\Entity\State")
     * @ORM\JoinColumn(nullable=false)
     */
    private $state;
    
    /**
     * @ORM\ManyToMany(targetEntity="TV\CongresBundle\Entity\Date", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $dates;
    
    /**
     * @ORM\ManyToOne(targetEntity="TV\CongresBundle\Entity\Image", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     * @Assert\Valid
     */
    private $image;
    
    /**
     * @ORM\OneToMany(targetEntity="TV\CongresBundle\Entity\CongressRegistration", mappedBy="congres")
     * @ORM\JoinColumn(nullable=true)
     */
    private $congressRegistrations;
    
    /**
     * @var int
     *
     * @ORM\Column(name="price_day1", type="integer", nullable=true)
     */
    private $priceDay1;

    /**
     * @var int
     *
     * @ORM\Column(name="price_day2", type="integer", nullable=true)
     */
    private $priceDay2;
    
    /**
     * @var int
     *
     * @ORM\Column(name="price_both", type="integer", nullable=true)
     */
    private $priceBoth;

    /**
     * @var int
     *
     * @ORM\Column(name="group_price", type="integer", nullable=true)
     */
    private $groupPrice;

    /**
     * @var int
     *
     * @ORM\Column(name="event_price", type="integer", nullable=true)
     */
    private $eventPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="event", type="string", length=255, nullable=true)
     * @Assert\Length(min=3, minMessage="L'événement doit faire au moins {{ limit }} caractères.", max=255, maxMessage="L'événement ne peut pas passer les {{ limit }} caractères.")
     */
    private $event;
    
    /**
     * @ORM\ManyToMany(targetEntity="TV\UserBundle\Entity\User", mappedBy="followedCongresses")
     * @ORM\JoinColumn(nullable=true)
     */
    private $registeredMembers;

    public function __construct() 
    {
        $this->publicationDate = new \Datetime();
        $this->updatedAt = new \DateTime();
        $this->dates = new ArrayCollection();
    }
    
    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->updatedAt= new \DateTime();
    }
    
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
     * Set publicationDate
     *
     * @param \DateTime $publicationDate
     *
     * @return Congres
     */
    public function setPublicationDate($publicationDate)
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    /**
     * Get publicationDate
     *
     * @return \DateTime
     */
    public function getPublicationDate()
    {
        return $this->publicationDate;
    }
    
    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Congres
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Congres
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set localisation
     *
     * @param string $localisation
     *
     * @return Congres
     */
    public function setLocalisation($localisation)
    {
        $this->localisation = $localisation;

        return $this;
    }

    /**
     * Get localisation
     *
     * @return string
     */
    public function getLocalisation()
    {
        return $this->localisation;
    }

    /**
     * Set preProgram
     *
     * @param \TV\CongresBundle\Entity\Pdf $preProgram
     *
     * @return Congres
     */
    public function setPreProgram(\TV\CongresBundle\Entity\Pdf $preProgram)
    {
        $this->preProgram = $preProgram;

        return $this;
    }

    /**
     * Get preProgram
     *
     * @return \TV\CongresBundle\Entity\Pdf
     */
    public function getPreProgram()
    {
        return $this->preProgram;
    }

    /**
     * Set summary
     *
     * @param \TV\CongresBundle\Entity\Pdf $summary
     *
     * @return Congres
     */
    public function setSummary(\TV\CongresBundle\Entity\Pdf $summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return \TV\CongresBundle\Entity\Pdf
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Congres
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set state
     *
     * @param \TV\CongresBundle\Entity\State $state
     *
     * @return Congres
     */
    public function setState(\TV\CongresBundle\Entity\State $state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return \TV\CongresBundle\Entity\State
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Add date
     *
     * @param \TV\CongresBundle\Entity\Date $date
     *
     * @return Congres
     */
    public function addDate(\TV\CongresBundle\Entity\Date $date)
    {
        $this->dates[] = $date;

        return $this;
    }

    /**
     * Remove date
     *
     * @param \TV\CongresBundle\Entity\Date $date
     */
    public function removeDate(\TV\CongresBundle\Entity\Date $date)
    {
        $this->dates->removeElement($date);
    }

    /**
     * Get dates
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDates()
    {
        return $this->dates;
    }

    /**
     * Set image
     *
     * @param \TV\CongresBundle\Entity\Image $image
     *
     * @return Congres
     */
    public function setImage(\TV\CongresBundle\Entity\Image $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \TV\CongresBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add congressRegistration
     *
     * @param \TV\CongresBundle\Entity\CongressRegistration $congressRegistration
     *
     * @return Congres
     */
    public function addCongressRegistration(\TV\CongresBundle\Entity\CongressRegistration $congressRegistration)
    {
        $this->congressRegistrations[] = $congressRegistration;
        $congressRegistration->setCongres($this);
        return $this;
    }

    /**
     * Remove congressRegistration
     *
     * @param \TV\CongresBundle\Entity\CongressRegistration $congressRegistration
     */
    public function removeCongressRegistration(\TV\CongresBundle\Entity\CongressRegistration $congressRegistration)
    {
        $this->congressRegistrations->removeElement($congressRegistration);
        $congressRegistration->setCongres(null);
    }

    /**
     * Get congressRegistrations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCongressRegistrations()
    {
        return $this->congressRegistrations;
    }
    
    /**
     * Set priceDay1
     *
     * @param integer $priceDay1
     *
     * @return Congres
     */
    public function setPriceDay1($priceDay1)
    {
        $this->priceDay1 = $priceDay1;

        return $this;
    }

    /**
     * Get priceDay1
     *
     * @return int
     */
    public function getPriceDay1()
    {
        return $this->priceDay1;
    }

    /**
     * Set priceDay2
     *
     * @param integer $priceDay2
     *
     * @return Congres
     */
    public function setPriceDay2($priceDay2)
    {
        $this->priceDay2 = $priceDay2;

        return $this;
    }

    /**
     * Get priceDay2
     *
     * @return int
     */
    public function getPriceDay2()
    {
        return $this->priceDay2;
    }
    
     /**
     * Set priceBoth
     *
     * @param integer $priceBoth
     *
     * @return Congres
     */
    public function setPriceBoth($priceBoth)
    {
        $this->priceBoth = $priceBoth;

        return $this;
    }

    /**
     * Get priceBoth
     *
     * @return int
     */
    public function getPriceBoth()
    {
        return $this->priceBoth;
    }

    /**
     * Set groupPrice
     *
     * @param integer $groupPrice
     *
     * @return Congres
     */
    public function setGroupPrice($groupPrice)
    {
        $this->groupPrice = $groupPrice;

        return $this;
    }

    /**
     * Get groupPrice
     *
     * @return int
     */
    public function getGroupPrice()
    {
        return $this->groupPrice;
    }

    /**
     * Set eventPrice
     *
     * @param integer $eventPrice
     *
     * @return Congres
     */
    public function setEventPrice($eventPrice)
    {
        $this->eventPrice = $eventPrice;

        return $this;
    }

    /**
     * Get eventPrice
     *
     * @return int
     */
    public function getEventPrice()
    {
        return $this->eventPrice;
    }

    /**
     * Set event
     *
     * @param string $event
     *
     * @return Congres
     */
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }
    
    /**
     * Add registeredMember
     *
     * @param \TV\CongresBundle\Entity\User $registeredMember
     *
     * @return Congres
     */
    public function addRegisteredMember(\TV\UserBundle\Entity\User $registeredMember)
    {
        $this->registeredMembers[] = $registeredMember;
        $registeredMember->addRegistredMember($this);
        return $this;
    }

    /**
     * Remove registeredMember
     *
     * @param \TV\CongresBundle\Entity\User $registeredMember
     */
    public function removeRegisteredMember(\TV\UserBundle\Entity\User $registeredMember)
    {
        $this->registeredMembers->removeElement($registeredMember);
        $registeredMember->removeRegistredMember($this);
    }

    /**
     * Get registeredMembers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRegisteredMembers()
    {
        return $this->registeredMembers;
    }
    
    public function getUpdatedDate()
    {
        return $this->updatedDate;
    }

}
