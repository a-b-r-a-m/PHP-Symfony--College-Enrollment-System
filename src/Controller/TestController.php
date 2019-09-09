<?php

namespace App\Controller;

use App\Entity\Student;
use App\Entity\StudentSubject;
use App\Entity\Subject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/test")
 */
class TestController extends AbstractController
{
    /**
     * @Route("/create-subject")
     */
    public function createSubject()
    {
        $subject = new Subject();

        $subject
            ->setIme("Programiranje na Internetu")
            ->setKod("SIT126")
            ->setBodovi(5)
            ->setSemRedovni(5)
            ->setSemIzvanredni(7)
            ->setIzborni("da")
        ;

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($subject);

        $entityManager->flush();


        return new Response();
    }

    /**
     * @Route("/create-student")
     */
    public function createStudent()
    {
        $student = new Student();

        $student
            ->setEmail("fb43344@oss.unist.hr")
            ->setPassword("1234")
            ->setRole("student")
            ->setStatus("redovni")
        ;

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($student);
        $entityManager->flush();

        return new Response();
    }

    /**
     * @Route("/create-enrollment")
     */
    public function enrollStudentInSubject()
    {
        $subject = $this
            ->getDoctrine()
            ->getRepository(Subject::class)
            ->find(2)
        ;

        $student = $this
            ->getDoctrine()
            ->getRepository(Student::class)
            ->find(1)
        ;

        $studentSubject = new StudentSubject();

        $studentSubject
            ->setStudent($student)
            ->setSubject($subject)
            ->setStatus("enrolled")
        ;

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($studentSubject);
        $entityManager->flush();


        return new Response();
    }
}