<?php

namespace Vdvreede\TFrontendBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AccountRepository extends EntityRepository
{
    
    public function findOneByIdAndUser($accountId, $userId) {
        
        $query = $this->createQueryBuilder('a')
                ->where('a.id = :accountId')
                ->andWhere('a.userId = :userId')
                ->setParameter('accountId', $accountId)
                ->setParameter('userId', $userId)
                ->getQuery()->getOneOrNullResult();
        
        if ($query == null)
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException ();
        
         return $query;
        
    }
    
    public function findAllByUser($userId) {
        
        $query = $this->createQueryBuilder('a')
                ->where('a.userId = :userId')
                ->setParameter('userId', $userId)
                ->getQuery()->execute();
        
        return $query;
        
    }
    
}
