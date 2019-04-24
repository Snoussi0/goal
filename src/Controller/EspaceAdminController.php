<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class EspaceAdminController extends AbstractController
{
    /**
     * @Route("/espace_admin", name="espace_admin")
     */
    public function index()
    {
        return $this->render('espace_admin/index.html.twig', [
            'controller_name' => 'EspaceAdminController',
        ]);
    }

     /**
     * @Route("/espace_admin/envoyer", name="envoyer")
     */
    public function envoyer(Request $request,\Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Hello Email'))
        ->setFrom('medsnoussi0@gmail.com')
        ->setTo('medsnoussi0@gmail.com')
        ->setBody("hello snow");

        $mailer->send($message);
        return $this->redirectToRoute("espace_admin");
    }
}
