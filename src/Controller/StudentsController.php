<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Intl\Exception\NotImplementedException;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
/**
 * @Route("/students")
 */
class StudentsController extends AbstractController
{
    /**
     * @Route("/", name="students.index")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index()
    {
        $students = $this
            ->getDoctrine()
            ->getRepository(Student::class)
            ->findAll()
        ;

        return $this->render("students/index.html.twig", [
            "students" => $students
        ]);
    }

    /**
     * @Route("/create/", name="students.create")
     */
    public function create(Request $request)
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($student);
            $entityManager->flush();

            $this->addFlash('success', 'Student successfully created!');

            return $this->redirectToRoute("students.index");
        }

        return $this->render("students/create.html.twig", [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}/", name="students.edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, $id)   //sad kad iman sensio, mogu samo stavit Student $student u argument i on ce sam povuc po id-u
    {
        $student = $this
            ->getDoctrine()
            ->getRepository(Student::class)
            ->find($id)
        ;

        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        //if(!($student instanceof Student))
          //  throw new NotFoundHttpException();
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($student);
            $entityManager->flush();

            $this->addFlash('success', 'Student successfully edited!');

            return $this->redirectToRoute('students.index');
        }

        return $this->render("students/edit.html.twig", [
            "student" => $student,
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}/", name="students.delete")
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete($id)
    {
        $student = $this
            ->getDoctrine()
            ->getRepository(Student::class)
            ->find($id)
        ;

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($student);
        $entityManager->flush();

        $this->addFlash('success', 'Student successfully deleted!');

        return $this->redirectToRoute("students.index");
    }
}