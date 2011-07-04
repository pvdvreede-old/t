<?php

namespace Vdvreede\TFrontendBundle\Repository;

class BaseRepository extends \Doctrine\ORM\EntityRepository {

    public function findOneByIdAndUser($itemId, $userId) {

        $query = $this->createQueryBuilder('a')
                ->where('a.id = :itemId')
                ->andWhere('a.userId = :userId')
                ->setParameter('itemId', $itemId)
                ->setParameter('userId', $userId)
                ->getQuery()
                ->getOneOrNullResult();

        if ($query == null)
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();

        return $query;
    }

    public function findAllByUserId($userId, $offset=0, $limit=0) {

        $query = $this->createQueryBuilder('a')
                        ->where('a.userId = :userId')
                        ->setParameter('userId', $userId)
                        ;
        if ($offset != 0)
            $query->setFirstResult ($offset);
        
        if ($limit != 0)
            $query->setMaxResults ($limit);


        return $query;
    }

    public function countAllByUserId($userId) {

        $query = $this->createQueryBuilder('a')
                        ->select('COUNT(a.id)')
                        ->where('a.userId = :userId')
                        ->setParameter('userId', $userId);
                        

        return $query;
    }
    
    public function deleteByUserAndIds($userId, $ids) {
        
        $qb = $this->createQueryBuilder('a');
        
        $query = $qb
                ->delete()
                ->where('a.userId = :userId')
                ->setParameter('userId', $userId)
                ->andWhere($qb->expr()->in('a.id', $ids));
        
        return $query;
        
    }

}