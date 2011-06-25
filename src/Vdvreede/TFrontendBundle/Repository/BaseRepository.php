<?php

namespace Vdvreede\TFrontendBundle\Repository;


class BaseRepository extends \Doctrine\ORM\EntityRepository 
{
    public function findOneByIdAndUser($itemId, $userId) {
        
        $query = $this->createQueryBuilder('a')
                ->where('a.id = :itemId')
                ->andWhere('a.userId = :userId')
                ->setParameter('itemId', $itemId)
                ->setParameter('userId', $userId)
                ->getQuery()->getOneOrNullResult();
        
        if ($query == null)
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException ();
        
         return $query;
        
    }
    
    public function findAllByUserId($userId) {
        
        $query = $this->createQueryBuilder('a')
                ->where('a.userId = :userId')
                ->setParameter('userId', $userId)
                ->getQuery()->execute();
        
        return $query;
        
    }
       
}