<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Profondeur;
use App\Entity\Tableplongee;
use App\Entity\Temps;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;



/**
* @Route("/api", name="api")
*/

class ApiController extends AbstractController
{
	/**
     * @Route("/profondeur", name="profondeur")
     */

	public function listProfondeur()
	{
		$profondeurs =$this->getDoctrine()
                    ->getRepository(Profondeur::class)
                    ->findApiAll();
    

        
        $response = new Response();
        
        $response->setContent(json_encode($profondeurs));
		$response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
        //$response = 

	}
	/**
     * @Route("/profondeur/show/{id}", name="show_profondeur")
     */
    public function showCours($id)
    {
       
        $profondeur = $this->getDoctrine()
            ->getRepository(Profondeur::class)
            ->findApiId($id);

        if (!$profondeur) {
            $data = [
                'status' => 404,
                'errors' => "Post not found",
               ];
            return new JsonResponse($data);
        }

        //return new JsonResponse($cours);
        $response = new Response();
        
        $response->setContent(json_encode($profondeur));
		$response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
        
    }

	/**
     * @Route("/tables", name="tables")
     */

	public function listTable()
	{
		$Tables =$this->getDoctrine()
                    ->getRepository(Tableplongee::class)
                    ->findApiAll();

        $response = new Response();
        
        $response->setContent(json_encode($Tables));
		$response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
        //$response = 

	}
	/**
     * @Route("/temps", name="temps")
     */

	public function listTemps()
	{
		$tmp =$this->getDoctrine()
                    ->getRepository(Temps::class)
                    ->findApiAll();
   
        $response = new Response();
        
        $response->setContent(json_encode($tmp));
		$response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
        //$response = 

	}

	/**
     * @Route("/tables/show/{id}", name="show_choix")
     */

	public function choix($id) {
		$tb =$this->getDoctrine()
                    ->getRepository(Tableplongee::class)
                    ->findTables($id);

        if ($id ==0 || $id >2 ) {
            $data = [
                'status' => 404,
                'errors' => "Wrong numb for table use 1 or 2 only ( 1: Bulhman, 2:MN90) ",
               ];
            return new JsonResponse($data);
     		}


        
  
        $response = new Response();
        
        $response->setContent(json_encode($tb));
		$response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
        //$response = 

	}


	/**
     * @Route("/calc", name="calc")
     */
	

	public function calc(){
		# Zone des constantes
		$respiration_moyenne = 1/3;   # 20L/min = 1/3 L/s
		$vitesse_descente = 1/3;      # 20m/min = 1/3 m/s
		$vitesse_remonte_avant_pallier = 1/6; # 10m/min => 1/6m/s
		$vitesse_remonte_entre_pallier = 1/10;   # 6m/min => 1/10m/s
		$evolution_bar = 0.1;               # Le bar évolue de 1/30 toutes les secondes pour une remontée de 20m/min
		$bar = 1;
		$pression_bouteille = 200;    # 200 bar
		$volume_bouteille = 13;
		$tables = 1;
		$good =0;
		$data = array();

		# On travaille en secondes, en mètre et en Litres
		# On récupère les données utilisateur

		$profondeur = 42;
		$duree_plongee_min= 10; # (mètre) Avant de l'utiliser, vérifier si la profondeur existe et sinon prendre la profondeur immédiatement au dessus
		$duree_plongee_sec = $duree_plongee_min * 60; # (seconde) -> 20 min
		$contenance_bouteille = $pression_bouteille * $volume_bouteille;

		$temps_descente = $profondeur/$vitesse_descente;  

		$evo_bar = $evolution_bar * $vitesse_descente;
		

		for ($i=0; $i<=$temps_descente; $i++){
			$contenance_bouteille -= $respiration_moyenne*$bar;
    		$bar += $evo_bar ;     
		}

		$contenance_bouteille= round($contenance_bouteille, 2);
		$contenance_bouteille_ap_desc = $contenance_bouteille;

		

		$bar = round($bar,2);
		$bar_av_rem = $bar;
		$verif=0;
		$new_profondeur=0;
		
			
	        
	      

		$duree_au_fond_sec = $duree_plongee_sec - $temps_descente;
		$duree_au_fond_min = floor($duree_au_fond_sec/60);
	
		while($verif == 0){
			
			$new_bar=$bar;
			$new_profondeur = $profondeur;
			$new_contenance_bouteille = $contenance_bouteille;



			if ($good==0){
		    	$temps_calc = $this->getDoctrine()
		                    ->getRepository(Tableplongee::class)
		                    ->findTime($duree_au_fond_min,$profondeur,$tables);
		                    
		    }

		    elseif($good == 1){
		    	
		    
		    	$temps_calc = $this->getDoctrine()
		                    ->getRepository(Tableplongee::class)
		                    ->findTime_error($duree_au_fond_min,$profondeur,$tables);
		                    
		      	
		    }

	        
	        for( $i=0; $i <= $duree_au_fond_sec; $i ++){
				$new_contenance_bouteille -= $respiration_moyenne*$new_bar;
			}
			 

			$new_contenance_bouteille = round($new_contenance_bouteille, 2);
			$contenance_bouteille_av_rem = $new_contenance_bouteille;

			
		

                   // var_dump($temps_calc);
             

	        $isVisited = False;
	        $palier = array();

	        foreach ($temps_calc[0] as $key => $value) {
	        	if ($key != "temps") {
	        		array_push($palier, array(intval(str_replace('palier',"",$key)), $value));
	        	}
	        }

	       
	      
			foreach ($palier as $key => $value) {
					if ($value[1] != 0) {
						
						$profToParcours = abs($value[0] - $new_profondeur);
	        			$new_profondeur -= $profToParcours;
	        			

	        			if ($isVisited == True) {
	        				$evo_bar = $evolution_bar * $vitesse_remonte_entre_pallier;
				            $timeProfToParcours = $profToParcours / $vitesse_remonte_entre_pallier;

				        }

				        else{
				            $evo_bar = $evolution_bar * $vitesse_remonte_avant_pallier;
				            $timeProfToParcours = $profToParcours / $vitesse_remonte_avant_pallier;
				        }

				         for ($i =0; $i <= $timeProfToParcours; $i ++){
				            $new_contenance_bouteille -= $respiration_moyenne*$new_bar;
				            $new_bar -= $evo_bar;

				        }	



			        # Consommation d'air sur la durée du palier désiré
				        for ($i = 0; $i <= $value[1]*60; $i ++){
				            $new_contenance_bouteille -= $respiration_moyenne*$new_bar;
				        }

				        $new_contenance_bouteille= round($new_contenance_bouteille, 2);
				        $new_bar = round($new_bar, 2);
				      

				        $isVisited = True;
        			}	
        		}

	    	for ($i = 0;$i <= $new_profondeur/$vitesse_remonte_entre_pallier; $i++){
		        $new_contenance_bouteille -= $respiration_moyenne*$new_bar;		        
		    	$new_bar-=$evo_bar;

		    }

		    $new_contenance_bouteille = round($new_contenance_bouteille, 2);
		    $contenance_bouteille_fin = $new_contenance_bouteille;
		    
			$new_bar = round($new_bar, 2);
			$bar_fin= $new_bar;

			if ($contenance_bouteille_fin < $pression_bouteille*$volume_bouteille*0.1){
				$verif = 0;
				$good =1;
				echo $contenance_bouteille_fin.'<br/>';
				echo $contenance_bouteille*0.1;
			}
			else{
				$verif=1;

				$palier = $value[0];
				$tps = $value[1];
				$dtp = $timeProfToParcours + $duree_plongee_min;

				$data["palier"] = $palier; 
				$data["temps"] = $tps;
				$data["duree_plongee"] = $dtp;
				$data["contenance_bouteille_av_rem"] =$contenance_bouteille_av_rem;
				$data["contenance_bouteille_fin"] = $contenance_bouteille_fin;
				$data["bar_av_rem"] = $bar_av_rem;
				$data["bar_fin"] = $bar_fin;

				var_dump($data);


			}
		
		}
	 //  	$response = new Response();

		//  $response->setContent(json_encode($data));
		//  $response->headers->set('Content-Type', 'application/json');
		// $response->headers->set('Access-Control-Allow-Origin', '*');
  //       return $response;
	 }

 						
}


