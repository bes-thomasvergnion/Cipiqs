<?php

namespace TV\CongresBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="TV\CongresBundle\Repository\ImageRepository")
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks
 */
class Image
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
     * @Vich\UploadableField(mapping="image", fileNameProperty="name", size="size")
     * @Assert\Image(
     *     maxSize = "500k",
     *     mimeTypes = {"image/jpeg", "image/png"},
     *     mimeTypesMessage = "Veuillez uploader un fichier JPEG ou PNG",
     *     minWidth = 350,
     *     maxWidth = 350,
     *     minHeight = 240,
     *     maxHeight = 240
     * )
     * @var File
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $name;
    
    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $alt;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $size;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null === $this->file) {
            return;
        }
        $this->alt = $this->file->getClientOriginalName();
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
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     * @return Image
     */
    public function setFile(File $image = null)
    {
        $this->file = $image;
        if ($image) {
            $this->updatedAt = new \DateTimeImmutable();
        }
        return $this;
    }

    /**
     * @return File|null
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string $name
     *
     * @return Image
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }
    
    /**
     * @param integer $size
     *
     * @return Image
     */
    public function setSize($size)
    {
        $this->size = $size;
        
        return $this;
    }

    /**
     * @return integer|null
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Image
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
}
