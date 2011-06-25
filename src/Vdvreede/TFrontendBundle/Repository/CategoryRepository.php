<?php

namespace Vdvreede\TFrontendBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
    
    public function findOneByIdAndUser($accountId, $userId) {
        
        $query = $this->createQueryBuilder('c')
                ->where('c.id = :accountId')
                ->andWhere('c.userId = :userId')
                ->setParameter('accountId', $accountId)
                ->setParameter('userId', $userId)
                ->getQuery()->getOneOrNullResult();
        
        if ($query == null)
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException ();
        
         return $query;
        
    }
    
    public function findAllByUser($userId) {
        
        $query = $this->createQueryBuilder('c')
                ->where('c.userId = :userId')
                ->setParameter('userId', $userId)
                ->getQuery()->execute();
        
        return $query;
        
    }
    
}
