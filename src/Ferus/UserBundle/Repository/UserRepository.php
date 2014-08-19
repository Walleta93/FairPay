<?php

namespace Ferus\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Ferus\AccountBundle\Entity\Account;
use Ferus\SellerBundle\Entity\Seller;
use Ferus\StudentBundle\Entity\Student;

/**
 * AccountRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
    public function querySearch($query)
    {
        $qb = $this->createQueryBuilder('u');

        $query = trim($query);
        $words = explode(' ', $query);

        foreach($words as $key => $word){
            $qb
                ->andWhere("u.username LIKE :query$key")
                ->setParameter("query$key", "%$word%");
        }

        return $qb->getQuery();
    }

    public function queryAdmins()
    {
        $roles = array(
            'ROLE_ADMIN',
            'ROLE_USER_ADMIN',
            'ROLE_STUDENT_ADMIN',
            'ROLE_SELLER_ADMIN',
            'ROLE_ACCOUNT_ADMIN',
            'ROLE_TRANSACTION_ADMIN',
            'ROLE_WITHDRAWAL_ADMIN',
            'ROLE_SUPER_ADMIN',
        );

        $qb = $this->createQueryBuilder('u');

        foreach($roles as $key => $role){
            $qb
                ->orWhere("u.roles LIKE :role$key")
                ->setParameter("role$key", "%\"$role\"%");
        }

        return $qb->getQuery();

    }
}
