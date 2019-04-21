<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Agence;
use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

class EspaceAgenceController extends AbstractController
{
    /**
     * @Route("/espace_agence", name="espace_agence")
     */
    public function index()
    {
        return $this->render('espace_agence/index.html.twig', [
            'controller_name' => 'EspaceAgenceController',
        ]);
    }

    /**
     * @Route("/espace_agence/modifier_adresse", name="espace_agence_modifier_adresse")
     */
    public function modifier_adresse()
    {
        return $this->render('espace_agence/modifier_adresse.html.twig', [
            'controller_name' => 'EspaceAgenceController',
        ]);
    }


    
    /**
     * @Route("/espace_agence/changer_adresse", name="espace_agence_changer_adresse")
     */
    public function changer_adresse(Request $request,ObjectManager $manager)
    {   
        $user = $this->getUser();
        $agenceRepo = $this->getDoctrine()->getRepository(Agence::class);

        $agence = $agenceRepo->find($user->getAgence()->getId());

        $agence->setLatitude($request->request->get('latitude'));
        $agence->setLongitude($request->request->get('longitude'));

        $this->getDoctrine()->getManager()->flush(); 
       
       return $this->redirect($this->generateUrl('espace_agence_modifier_adresse',['notification' => 'success','contenu'=>'modification terminée avec succès' ]));
       
    }
    


}
