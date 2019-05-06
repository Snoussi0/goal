<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Terrain;
use App\Entity\Reservation;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

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
    public function reservation($id,Request $request,ObjectManager $manager)
    {
        
        $terrain = $this->getDoctrine()
        ->getRepository(Terrain::class)
        ->find($id);
        
        $agence=$terrain->getAgence();
        if ($request->isMethod('post')) 
        {
            
            $date=$request->request->get('date');
            $heure=$request->request->get('heure');
            $dateh = new \DateTime($date.' '.$heure.':00:00');
            
            $reservation=new Reservation();
            
            $reservation->setDate($dateh)
                        ->setStatus('wait')
                        ->setTerrain($terrain)
                        ->setClient( $this->getUser()->getClient());
            $manager->persist($reservation);
            $manager->flush(); 
            return $this->render('espace_client/reservation.html.twig', [
                'terrain' => $terrain,'agence'=>$agence,'notification' => 'success','contenu'=>'Demande De Reservation effectuee' 
            ]);
          
        }
        else
        {

            return $this->render('espace_client/reservation.html.twig', [
                'terrain' => $terrain,'agence'=>$agence
            ]);
        }

    }
}
