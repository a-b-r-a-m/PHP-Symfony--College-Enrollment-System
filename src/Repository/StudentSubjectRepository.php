<?php

namespace App\Repository;

use App\Entity\StudentSubject;
use App\Entity\Subject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StudentSubject|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudentSubject|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudentSubject[]    findAll()
 * @method StudentSubject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentSubjectRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StudentSubject::class);
    }

    // /**
    //  * @return StudentSubject[] Returns an array of StudentSubject objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function findSubjectsAssignedToStudent($student)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.student = :student')
            ->setParameter('student', $student)
            ->getQuery()
            ->getResult();
    }


    public function findOneById($student, $subject): ?StudentSubject
    {
        return $this->createQueryBuilder('ss')
            ->andWhere('ss.student = :student')
            ->setParameter('student', $student)
            ->andWhere('ss.subject = :subject')
            ->setParameter('subject', $subject)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
