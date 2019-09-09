<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default.index")
     */
    public function index()
    {
       // neznan jel potrebno /** @var \App\Entity\User $user */
        $this->get('security.token_storage')->getToken()->getUser();

        return $this->render("default/index.html.twig");
    }
}