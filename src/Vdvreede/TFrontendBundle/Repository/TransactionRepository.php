<?php

namespace Vdvreede\TFrontendBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TransactionRepository extends BaseRepository {

    public function findAllByUserAccount($userId, $accountId, $offset=0, $limit=0) {
        $query = parent::findAllByUserId($userId, $offset, $limit);

        if ($accountId != 0)
            $query->andWhere('a.accountId = :accountId')
                    ->setParameter('accountId', $accountId);

        return $query;
    }

    public function countAllByUserAccount($userId, $account) {

        $query = parent::countAllByUserId($userId);

        if ($account != 0)
            $query->andWhere('a.accountId = :accountId')
                    ->setParameter('accountId', $account);

        return $query;
    }
    
    public function updateByUserId($userId, $ids, $fields) {
        
        $qb = $this->createQueryBuilder('a');
        
        $query = $qb->update()
                ->where('a.userId = :userId')
                ->setParameter('userId', $userId)
                ->andWhere($qb->expr()->in('a.id', $ids));
        
        foreach ($fields as $name => $value) {
            $query->set('a.'.$name, $value);
        }
        
        return $query;
    }

}
