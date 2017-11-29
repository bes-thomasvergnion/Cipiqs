<?php

namespace TV\CongresBundle\Repository;

/**
 * ImageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ImageRepository extends \Doctrine\ORM\EntityRepository
{
    public function listImages(){
        $qb = $this->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC');
            
        return $qb
            ->getQuery()
            ->getResult()
        ;
    }
}