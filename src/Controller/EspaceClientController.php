<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EspaceClientController extends AbstractController
{
    /**
     * @Route("/espace_client", name="espace_client")
     */
    public function index()
    {
        $user = $this->getUser();
        return $this->render('espace_client/index.html.twig', [
            'controller_name' => 'EspaceClientController','utilisateur'=>$user
        ]);
    }
}
