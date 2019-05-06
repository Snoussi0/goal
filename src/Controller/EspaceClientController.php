<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Terrain;

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


    /**
     * @Route("/espace_client/reservation/{id}", name="espace_client_reservation")
     */
    public function reservation($id)
    {
        $terrain = $this->getDoctrine()
        ->getRepository(Terrain::class)
        ->find($id);
        $agence=$terrain->getAgence();
        return $this->render('espace_client/reservation.html.twig', [
            'terrain' => $terrain,'agence'=>$agence
        ]);

    }
}
