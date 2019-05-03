<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\Agence;
use App\Entity\Utilisateur;
use App\Entity\Client;
use App\Entity\Terrain;

class EspacePublicController extends AbstractController
{   




      /**
     * @Route("/", name="accueil")
     */
    public function accueil()
    {
        return $this->render('espace_public/accueil.html.twig');
    }



    
    /**
     * @Route("/nos_terrains", name="espace_public_nos_terrains")
     */
    public function nos_terrains(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Terrain::class);
        $terrain = $repository->findAll();
        
        
        return $this->render('espace_public/nos_terrains.html.twig', [
            'terrains' => $terrain,
        ]);
    }




     /**
     * @Route("/nos_agences", name="espace_public_nos_agences")
     */
    public function nos_agences()
    {

        $repository = $this->getDoctrine()->getRepository(Agence::class);
        $agence = $repository->findAll();
        
        
        return $this->render('espace_public/nos_agences.html.twig', [
            'agences' => $agence,
        ]);
    }




    
     /**
     * @Route("/nos_tournois", name="espace_public_nos_tournois")
     */
    public function nos_tournois()
    {
        return $this->render('espace_public/nos_tournois.html.twig');
    }



    
      /**
     * @Route("/inscription", name="inscription")
     */
    public function inscription()
    {
        return $this->render('espace_public/inscription.html.twig');
    }


      /**
     * @Route("/inscription/inscription_client", name="espace_public_inscription_client")
     */
    public function inscription_client()
    {
        return $this->render('espace_public/inscription_client.html.twig');
    }


        /**
     * @Route("/inscription/inscription_agencec", name="espace_public_inscription_agence")
     */
    public function inscription_agence()
    {
        return $this->render('espace_public/inscription_agence.html.twig');
    }






    





    /**
     * @Route("/connexion", name="espace_public_connexion")
     */
    public function connexion(AuthenticationUtils $authenticationUtils)
    {
        
        $error = $authenticationUtils->getLastAuthenticationError();
        return $this->render('espace_public/connexion.html.twig', [
            'error' => $error
        ]);



    }


    


    
  





    
    /**
     * @Route("/ajouter_client", name="ajouter_client")
     */
    public function ajouter_client(Request $request,ObjectManager $manager,UserPasswordEncoderInterface $passwordEncoder)
    {   

        
        $repository=$this->getDoctrine()->getRepository(Utilisateur::class);
        $utilisateur1=$repository->findOneBy(['email' => ($request->request->get('email'))]);
        if($utilisateur1==null)
        {
            $utilisateur=new Utilisateur();
            $utilisateur->setEmail($request->request->get('email'))
                        ->setMotPasse($request->request->get('mot_passe'))
                        ->setRole('ROLE_CLIENT');
                 
            $client=new Client();
            
            $client->setPrenom($request->request->get('prenom'))
                    ->setNom($request->request->get('nom'))
                    ->setSexe($request->request->get('sexe'))
                    ->setDateNaissance(new \DateTime($request->request->get('date_naissance')));

            if($client->getSexe()=="homme")
            {
                $client->setPhoto("/images/icone/boy.svg");
            }
            else
            {
                $client->setPhoto("/images/icone/girl.svg");
            }
            $utilisateur->setMotPasse($passwordEncoder->encodePassword($utilisateur,$utilisateur->getMotPasse())  );

            $utilisateur->setClient($client);
            $manager->persist($client);
            $manager->persist($utilisateur);
            $manager->flush();  
            
            
            
            $notification="success";
            $contenu="ajout avec success";
            
            
        }
        else
        {
            

            $notification="danger";
            $contenu="Email deja existe";         
            
            

        }


        return $this->render('espace_public/inscription_client.html.twig',array('notification' => $notification,'contenu'=>$contenu ));
     
    }


    /**
     * @Route("/login", name="login")
     */
    public function login()
    {   
        
        return $this->redirectToRoute('espace_client');


    }

 /**
     * @Route("/after_login_route", name="after_login_route")
     */
    public function after_login_route_name()
    {   
        $user = $this->getUser();
        if($user->getRole()=="ROLE_CLIENT")
        {
            return $this->redirectToRoute('espace_client');
        }
        else
        {
            if($user->getRole()=="ROLE_AGENCE")
            {
                return $this->redirectToRoute('espace_agence');
            }
            else
            {
                if($user->getRole()=="ROLE_ADMIN")
                {
                    return $this->redirectToRoute('easyadmin');
                } 
                else
                {
                    return $this->redirectToRoute('espace_public_connexion');
                }
            }   
        }

    }
       
    /**
     * @Route("/logout", name="logout")
     */
    public function logout(Request $request)
    {   


    }







    
    /**
     * @Route("/ajouter_agence", name="ajouter_agence")
     */
    public function ajouter_agence(Request $request,ObjectManager $manager,UserPasswordEncoderInterface $passwordEncoder)
    {
        $repository=$this->getDoctrine()->getRepository(Utilisateur::class);
        $utilisateur1=$repository->findOneBy(['email' => ($request->request->get('email'))]);

        $repositorya=$this->getDoctrine()->getRepository(Agence::class);
        $agence1=$repositorya->findOneBy(['matriculeFiscale' => ($request->request->get('matricule_fiscale'))]);

        if($utilisateur1==null and $agence1==null)
        {
            $utilisateur=new Utilisateur();
            $utilisateur->setEmail($request->request->get('email'))
                        ->setMotPasse($request->request->get('mot_passe'))
                        ->setRole('ROLE_AGENCE');

            $agence=new Agence();
            $agence->setMatriculeFiscale($request->request->get('matricule_fiscale'));
            $agence->setNom($request->request->get('nom_agence'));
            
            $agence->setPhoto("agence_hover.jpg");
            $agence->setNumTel($request->request->get('num_tel'));
           

            $notification="wait";
            $contenu="Vous recevez un <a href='https://mail.google.com' target='_blank'>mail</a> lorsque les informations saisies sont vérifiées";

            
            $utilisateur->setMotPasse($passwordEncoder->encodePassword($utilisateur,$utilisateur->getMotPasse())  );

            $utilisateur->setAgence($agence);

            $manager->persist($agence);
            $manager->persist($utilisateur);
            
            $manager->flush();          
            
        }
        else
        {   
            
            $notification="danger";

            if($utilisateur1<>null)
            {
                $contenu="Email deja existe";         

            }
            else
            {
                $contenu="N° de matricule fiscale deja existe";  
            }
        
            

            
        }
        
        return $this->render('espace_public/inscription_agence.html.twig',array('notification' => $notification,'contenu'=>$contenu ));

    }





    
    /**
     * @Route("/espace_public_votre_profile", name="espace_public_votre_profile")
     */
    public function votre_profile()
    {
        $role = $this->getUser()->getRole();
        if($role == "ROLE_CLIENT")
        {
            return $this->redirectToRoute('espace_client');
        }
        else
        {
            if($role == "ROLE_AGENCE")
            {
                return $this->redirectToRoute('espace_agence');
            }
            else
            {
                if($role == "ROLE_ADMIN")
                {
                    return $this->redirectToRoute('easyadmin');
                }

            }
        }
    }


    
}
