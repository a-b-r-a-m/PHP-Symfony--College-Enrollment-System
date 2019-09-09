<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Form\SubjectType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/subjects")
 */
class SubjectsController extends AbstractController
{
    /**
     * @Route("/", name="subjects.index")
     */
    public function index()
    {
        $subjects = $this
            ->getDoctrine()
            ->getRepository(Subject::class)
            ->findAll()
        ;

        return $this->render("subjects/index.html.twig", [
            "subjects" => $subjects,
        ]);
    }

    /**
     * @Route("/create/", name="subjects.create")
     */
    public function create(Request $request)        //problem? ili samo upozorenje
    {
        $subject = new Subject();
        $form = $this->createForm(SubjectType::class, $subject);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($subject);
            $entityManager->flush();

            $this->addFlash('success', 'Predmet uspješno dodan!');
            return $this->redirectToRoute('subjects.index');
        }

        return $this->render("subjects/create.html.twig", [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="subjects.edit")
     */
    public function edit(Request $request, $id)
    {
        $subject = $this
            ->getDoctrine()
            ->getRepository(Subject::class)
            ->find($id)
        ;

        $form = $this->createForm(SubjectType::class, $subject);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($subject);
            $entityManager->flush();

            $this->addFlash('success', 'Predmet uspješno uređen!');

            return $this->redirectToRoute('subjects.index');
        }

        return $this->render("subjects/edit.html.twig", [
            "subject" => $subject,
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="subjects.delete")
     */
    public function delete($id)
    {
        $subject = $this
            ->getDoctrine()
            ->getRepository(Subject::class)
            ->find($id)
        ;

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($subject);
        $entityManager->flush();

        $this->addFlash('success', 'Predmet uspješno obrisan!');

        return $this->redirectToRoute("subjects.index");
    }
}