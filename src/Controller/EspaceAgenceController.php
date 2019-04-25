<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Agence;
use App\Entity\Utilisateur;
use App\Entity\Terrain;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
     * @Route("/espace_agence/modifier_terrain", name="espace_agence_modifier_terrain")
     */
    public function modifier_terrain(Request $request)
    {
        
        $agence=$this->getUser()->getAgence();
       
        $repository = $this->getDoctrine()->getRepository(Terrain::class);

        $terrain = $repository-> findBy(['agence' => $agence]);
        return $this->render('espace_agence/modifier_terrain.html.twig', [
            'terrains' => $terrain,
        ]);
    }



      /**
     * @Route("/espace_agence/ajouter_terrain", name="espace_agence_ajouter_terrain")
     */
    public function ajouter_terrain()
    {
        return $this->render('espace_agence/ajouter_terrain.html.twig', [
            'controller_name' => 'EspaceAgenceController',
        ]);
    }

     /**
     * @Route("/espace_agence/ajouter_terrains", name="espace_agence_ajouter_terrains")
     */
    public function ajouter_terrains(Request $request,ObjectManager $manager)
    {

       
        $terrain=new Terrain();
        $terrain->setNom($request->request->get('nom'))
                ->setLargeur($request->request->get('largeur'))
                ->setLongueur($request->request->get('longueur'))
                ->setCategorie($request->request->get('categorie'))
                ->setPrix($request->request->get('prix'))
                ->setAgence($this->getUser()->getAgence());
                 
            
        $manager->persist($terrain);
        $manager->flush();  
            
            
            
            $contenu="ajout de terrain avec success";
            
            
        
            return $this->redirect($this->generateUrl('espace_agence_ajouter_terrain',['notification' => 'success','contenu'=>$contenu ]));
       

        
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
