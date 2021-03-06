<?php

namespace Ferus\StudentBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Ferus\StudentBundle\Entity\Student;

/**
 * StudentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StudentRepository extends EntityRepository
{
    public function findOneById($id)
    {
        return $this->createQueryBuilder('s')
            ->where('s.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult();
    }

    public function queryAll()
    {
        return $this->createQueryBuilder('s')
            ->getQuery();
    }

    public function search($query = null, $maxResult = 50)
    {
        return $this->querySearch($query)->setMaxResults($maxResult)->getResult();
    }

    public function querySearch($query = null)
    {
        $qb = $this->createQueryBuilder('s');
        if($query == null) return $qb->getQuery();

        $query = trim($query);
        $words = explode(' ', $query);

        if(count($words) === 1){
            if(preg_match('/^[0-9]+$/', $query))
                $qb
                    ->where('s.id = :id')
                    ->setParameter('id', $query);
            else
                $qb
                    ->where('s.firstName LIKE :query')
                    ->orWhere('s.lastName LIKE :query')
                    ->setParameter('query', "%$query%");
        }
        else{
            foreach($words as $key => $word){
                $qb
                    ->andWhere("s.firstName LIKE :query$key OR s.lastName LIKE :query$key")
                    ->setParameter("query$key", "%$word%");
            }
        }

        return $qb->getQuery();
    }

    public function remove(Student $student)
    {
        $this->createQueryBuilder('s')
            ->delete()
            ->where('s = :student')
            ->setParameter('student', $student)
            ->getQuery()
            ->execute();
    }

    /**
     * @param Student $student
     * @return Student|null
     */
    public function findSoftDeleted(Student $student)
    {
        $query = $this->createQueryBuilder('s')
            ->where('s.deletedAt IS NOT NULL')
            ->andWhere('s = :student')
            ->setParameter('student', $student)
            ->getQuery()
        ;

        try{
            return $query->getSingleResult();
        }
        catch(NoResultException $e){
            return null;
        }
    }
}
