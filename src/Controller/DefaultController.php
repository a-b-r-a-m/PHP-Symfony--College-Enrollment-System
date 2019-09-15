<?php

namespace App\Controller;

use App\Entity\Student;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default.index")
     */
    public function index()
    {
       // /** @var \App\Entity\User $user */
        $this->get('security.token_storage')->getToken()->getUser();

        // $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if($this->isGranted('ROLE_ADMIN'))
            return $this->render("default/index.html.twig");

        $student = $this->getDoctrine()->getRepository(Student::class)->findOneByEmail((string)($this->getUser()));

        return $this->redirectToRoute('enrollments.index', ['studentId' => $student->getId()]);
    }
}