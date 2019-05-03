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
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;

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
     * @Route("/espace_agence/modifier_num_tel", name="espace_agence_modifier_num_tel")
     */
    public function modifier_num_tel()
    {
        return $this->render('espace_agence/modifier_num_tel.html.twig', [
            'controller_name' => 'EspaceAgenceController',
        ]);
    }

          /**
     * @Route("/espace_agence/changer_num_tel", name="espace_agence_changer_num_tel")
     */
    public function changer_num_tel(Request $request)
    {
        
        $agence=$this->getUser()->getAgence();
       


              
        $agence->setNumTel($request->request->get('num_tel'));
         
            
        
        
        $this->getDoctrine()->getManager()->flush();   
            
            
            
            $contenu="photo chager avec success";
            
            
        
       
            return $this->redirect($this->generateUrl('espace_agence_modifier_num_tel',['notification' => 'success','contenu'=>'modification terminée avec succès' ]));

        
    }
    


     /**
     * @Route("/espace_agence/modifier_photo", name="espace_agence_modifier_photo")
     */
    public function modifier_photo()
    {
        return $this->render('espace_agence/modifier_photo.html.twig', [
            'controller_name' => 'EspaceAgenceController',
        ]);
    }

          /**
     * @Route("/espace_agence/changer_photo", name="espace_agence_changer_photo")
     */
    public function changer_photo(Request $request)
    {
        
        $agence=$this->getUser()->getAgence();
       


                $file = $request->files->get('photo');
                
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory'),$fileName);
                $agence->setPhoto($fileName);
         
            
        
        
        $this->getDoctrine()->getManager()->flush();   
            
            
            
            $contenu="photo chager avec success";
            
            
        
       
            return $this->redirect($this->generateUrl('espace_agence_modifier_photo',['notification' => 'success','contenu'=>'modification terminée avec succès' ]));
          

        



        
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
                ->setPhoto($request->request->get('photo'))
                ->setAgence($this->getUser()->getAgence());

                $file = $request->files->get('photo');
                
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory'),$fileName);
                $terrain->setPhoto($fileName);
         
            
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
