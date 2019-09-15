<?php

namespace App\Controller;

use App\Entity\Student;
use App\Entity\StudentSubject;
use App\Entity\Subject;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Intl\Exception\NotImplementedException;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/enrollments")
 */
class EnrollmentsController extends AbstractController
{
    /**
     * @Route("/{studentId}", name="enrollments.index")
     */
    public function index($studentId)
    {
        $user = $this->getDoctrine()->getRepository(Student::class)->findOneByEmail((string)($this->getUser()));

        if($this->isGranted('ROLE_ADMIN') || $user->getId() == $studentId) {
            $doctrine = $this->getDoctrine();
            $repository = $doctrine->getRepository(StudentSubject::class);
            $student = $doctrine->getRepository(Student::class)->find($studentId);

            //$assignedSubjects = $student->getStudentSubjects();   //ne moze
            $assignedSubjects = $repository->findSubjectsAssignedToStudent($student);
            $studentSubjects = $assignedSubjects;

            if ($student->getStatus() == 'redovan')
                $allSubjects = $doctrine->getRepository(Subject::class)->findAllBySemRedovni();
            else
                $allSubjects = $doctrine->getRepository(Subject::class)->findAllBySemIzvanredni();

            $unassignedSubjects = array_diff($allSubjects, $assignedSubjects);

            $assignedSubjects = array_diff($allSubjects, $unassignedSubjects);


            return $this->render("enrollments/index.html.twig", [
                "student" => [
                    "id" => $studentId,
                    "email" => $student->getEmail(),
                    "status" => $student->getStatus(),
                ],
                "assignedSubjects" => $assignedSubjects
                ,
                "unassignedSubjects" => $unassignedSubjects
                ,
                "studentSubjects" => $studentSubjects
            ]);
        }

        return $this->redirectToRoute('enrollments.index', ['studentId' => $user->getId()]);
    }

    /**
     * @Route("/{studentId}/assign/{subjectId}", name="enrollments.assign")
     */
    public function assign($studentId, $subjectId)
    {
        $user = $this->getDoctrine()->getRepository(Student::class)->findOneByEmail((string)($this->getUser()));

        if($this->isGranted('ROLE_ADMIN') || $user->getId() == $studentId) {
            $doctrine = $this->getDoctrine();

            $student = $doctrine->getRepository(Student::class)->find($studentId);
            $subject = $doctrine->getRepository(Subject::class)->find($subjectId);

            $studentSubject = new StudentSubject();

            $studentSubject
                ->setStudent($student)
                ->setSubject($subject)
                ->setStatus("enrolled");

            $em = $doctrine->getManager();
            $em->persist($studentSubject);
            $em->flush();

            return $this->redirectToRoute('enrollments.index', ['studentId' => $studentId]);
        }

        return $this->redirectToRoute('enrollments.index', ['studentId' => $user->getId()]);
    }

    /**
     * @Route("/{studentId}/pass/{subjectId}", name="enrollments.pass")
     */
    public function pass($studentId, $subjectId)
    {
        $user = $this->getDoctrine()->getRepository(Student::class)->findOneByEmail((string)($this->getUser()));

        if($this->isGranted('ROLE_ADMIN') || $user->getId() == $studentId) {
            $doctrine = $this->getDoctrine();
            $em = $doctrine->getManager();

            $ss = $em->getRepository(StudentSubject::class)->findOneById($studentId, $subjectId);
            if ($ss->getStatus() == 'enrolled')
                $ss->setStatus("passed");
            else
                $ss->setStatus("enrolled");

            $em->persist($ss);
            $em->flush();

            return $this->redirectToRoute('enrollments.index', ['studentId' => $studentId]);
        }
        return $this->redirectToRoute('enrollments.index', ['studentId' => $user->getId()]);
    }

    /**
     * @Route("/{studentId}/remove/{subjectId}", name="enrollments.remove")
     */
    public function remove($studentId, $subjectId)
    {
        $user = $this->getDoctrine()->getRepository(Student::class)->findOneByEmail((string)($this->getUser()));

        if($this->isGranted('ROLE_ADMIN') || $user->getId() == $studentId) {
            $doctrine = $this->getDoctrine();

            $student = $doctrine->getRepository(Student::class)->find($studentId);
            $subject = $doctrine->getRepository(Subject::class)->find($subjectId);
            $rep = $doctrine->getRepository(StudentSubject::class);

            $sS = $rep->findOneBy(['student' => $student, 'subject' => $subject]);

            $em = $doctrine->getManager();
            $em->remove($sS);
            $em->flush();

            return $this->redirectToRoute('enrollments.index', ['studentId' => $studentId]);
        }

        return $this->redirectToRoute('enrollments.index', ['studentId' => $user->getId()]);
    }

}