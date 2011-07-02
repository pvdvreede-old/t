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

}
