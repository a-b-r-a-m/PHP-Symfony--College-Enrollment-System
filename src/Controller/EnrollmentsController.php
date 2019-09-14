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
        //napravit vamo kontrolu jel isti id usera i studenta kojen se list minja, ako je ROLE_USER
        // i za assign i delete isto
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository(StudentSubject::class);
        $student = $doctrine->getRepository(Student::class)->find($studentId);

        //$assignedSubjects = $student->getStudentSubjects();   //ne moze
        $assignedSubjects = $repository->findSubjectsAssignedToStudent($student);

        if($student->getStatus() == 'redovan')
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
        ]);
    }

    /**
     * @Route("/{studentId}/assign/{subjectId}", name="enrollments.assign")
     */
    public function assign($studentId, $subjectId)  //stavit da samo mentor moze stavit "passed"
    {
        $doctrine = $this->getDoctrine();

        $student = $doctrine->getRepository(Student::class)->find($studentId);
        $subject = $doctrine->getRepository(Subject::class)->find($subjectId);

        $studentSubject = new StudentSubject();

        $studentSubject
            ->setStudent($student)
            ->setSubject($subject)
            ->setStatus("enrolled")
        ;

        $em = $doctrine->getManager();
        $em->persist($studentSubject);
        $em->flush();

        return $this->redirectToRoute('enrollments.index', ['studentId' => $studentId]);
    }

    /**
     * @Route("/{studentId}/remove/{subjectId}", name="enrollments.remove")
     */
    public function remove($studentId, $subjectId)
    {
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

}