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

    public function findSubjectsAssignedToStudent($student) //mozda poredat po imenu jos, i ovo gori @return?
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.student = :student')
            ->setParameter('student', $student)
            ->orderBy('s.subject', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /*public function findSubjectAssignedToStudent($student, $subject) //mozda poredat po imenu jos, i ovo gori @return?
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.student = :student, s.subject = :subject')
            ->setParameter($student,  $subject)
            ->orderBy('s.subject', 'ASC')
            ->getQuery()
            ->getResult();
    }*/

    /*
    public function findOneBySomeField($value): ?StudentSubject
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
