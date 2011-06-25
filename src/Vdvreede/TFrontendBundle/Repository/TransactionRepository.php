<?php

namespace Vdvreede\TFrontendBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TransactionRepository extends EntityRepository
{
    public function findOneByIdAndUser($transId, $userId) {
        
        $query = $this->createQueryBuilder('a')
                ->where('a.id = :transId')
                ->andWhere('a.userId = :userId')
                ->setParameter('transId', $transId)
                ->setParameter('userId', $userId)
                ->getQuery()->getOneOrNullResult();
        
        if ($query == null)
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException ();
        
         return $query;
        
    }
    
    
    public function findAllByUser($userId) {
        
        $query = $this->createQueryBuilder('t')
                ->where('t.userId = :userId')
                ->setParameter('userId', $userId)
                ->getQuery()->execute();
        
        return $query;
        
    }
    
}
