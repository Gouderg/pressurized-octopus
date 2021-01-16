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

	}


	/**
     * @Route("/calc", name="calc")
     */
	public function main_calcul_plongee(){
		
		# Zone de saisie utilisateur
		$table_plonge = 1;
		$pression_bouteille = 200;
		$volume_bouteille = 15;
		$profondeur = 78;
		$duree_plongee = 78;

		# Constante
		$vitesse_descente = 1/3;

		$tempProfondeur = $this->getDoctrine()->getRepository(Profondeur::class)->dbRequestNextSupProf($table_plonge, $profondeur);
		
		if (empty($tempProfondeur)) {
			$profondeur = $this->getDoctrine()->getRepository(Profondeur::class)->dbRequestLastProf($table_plonge)[0]["profondeur"];
		} else {
			$profondeur = $tempProfondeur[0]['profondeur'];
		}
	
		$temps_au_fond = (($duree_plongee * 60 ) - ($profondeur/$vitesse_descente)) / 60;
		$tempPalier = $this->getDoctrine()->getRepository(Temps::class)->dbRequestNextSupTemps($table_plonge, $profondeur, $temps_au_fond);

		if (empty($tempPalier)) {
			$palier = $this->getDoctrine()->getRepository(Temps::class)->dbRequestLastTemps($table_plonge, $profondeur)[0];
		} else {
			$palier = $tempPalier[0];
		}

		while (1) {
			$data = $this->calcul_plongee($profondeur, $duree_plongee, $pression_bouteille, $volume_bouteille, $palier);
			if (empty($data)) {
				$tempPalier = $this->getDoctrine()->getRepository(Temps::class)->dbRequestBeforeTemps($table_plonge, $profondeur, $palier['temps']);
				if (empty($tempPalier)) {
					$profondeur = $this->getDoctrine()->getRepository(Profondeur::class)->dbRequestBeforeProf($table_plonge, $profondeur)[0]["profondeur"];
					$temps_au_fond = (($duree_au_fond * 60) - ($profondeur/$vitesse_descente)) / 60;
					$tempPalier = $this->getDoctrine()->getRepository(Temps::class)->dbRequestNextSupTemps($table_plonge, $profondeur, $temps_au_fond);
					if (empty($tempPalier)) {
						$palier = $this->getDoctrine()->getRepository(Temps::class)->dbRequestLastTemps($table_plonge, $profondeur)[0];
					} else {
						$palier = $tempPalier[0];
					}
				} else {
					$palier = $tempPalier[0];
				}
			} else {
				break;
			}
		}

		$response = new Response();
        
        $response->setContent(json_encode($data));
		$response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
	}
		
	public function calcul_plongee($profondeur, $temps, $pression_bouteille, $volume_bouteille, $palierUnparse) {
		# Zone des constantes de plongées
		$respiration_moyenne = 1/3; 				# 20 L/min => 1/3 L/s
		$vitesse_descente = 1/3;					# 20 m/min => 1/3 m/s
		$vitesse_remonte_avant_pallier = 1/6; 		# 10 m/min => 1/6 m/s
		$vitesse_remonte_entre_pallier = 1/10;		#  6 m/min => 1/10 m/s
		$evolution_bar = 0.1;						# Le bar évolue de 1/30 toutes les secondes pour une descente de 20m/min
		$bar = 1;
		$duree_plongee = $temps * 60;
		$contenance_bouteille = $pression_bouteille * $volume_bouteille;

		$data = [];

		# On cherche le temps de la descente
		$temps_descente = $profondeur / $vitesse_descente;
		$evo_bar = $evolution_bar * $vitesse_descente;

		# Descente
		list($contenance_bouteille, $bar, $data) = $this->forwardConsommation($temps_descente, $respiration_moyenne, $evo_bar, $bar, $contenance_bouteille, $data, $volume_bouteille);
		
		# Temps au fond de l'eau
		$duree_au_fond = $palierUnparse["temps"] * 60 - $temps_descente;
		list($contenance_bouteille, $bar, $data) = $this->forwardConsommation($duree_au_fond, $respiration_moyenne, 0, $bar, $contenance_bouteille, $data, $volume_bouteille);
	
		# On parse les paliers avant de continuer
		$palier = [[15,$palierUnparse["palier15"]], [12,$palierUnparse["palier12"]], [9,$palierUnparse["palier9"]], [6,$palierUnparse["palier6"]], [3,$palierUnparse["palier3"]]];
		
		$isVisited = FALSE;
		foreach($palier as $elt) {
			if ($elt[1]) {
				$profToParcours = $profondeur - $elt[0];
				$profondeur -= $profToParcours;

				if ($isVisited) {
					$evo_bar = $evolution_bar * $vitesse_remonte_entre_pallier;
					$timeProfToParcours = $profToParcours / $vitesse_remonte_entre_pallier;
				} else {
					$evo_bar = $evolution_bar * $vitesse_remonte_avant_pallier;
					$timeProfToParcours = $profToParcours / $vitesse_remonte_avant_pallier;
				}

				# Remontée jusqu'au palier
				list($contenance_bouteille, $bar, $data) = $this->forwardConsommation($timeProfToParcours, $respiration_moyenne, -$evo_bar, $bar, $contenance_bouteille, $data, $volume_bouteille);
				
				# Attente au palier
				list($contenance_bouteille, $bar, $data) = $this->forwardConsommation($elt[1]*60, $respiration_moyenne, 0, $bar, $contenance_bouteille, $data, $volume_bouteille);
				
				$isVisited = TRUE;
			}
		}

		# On parcours la distance restante pour remontée à la surface
		list($contenance_bouteille, $bar, $data) = $this->forwardConsommation($profondeur/$vitesse_remonte_entre_pallier, $respiration_moyenne, -$evo_bar, $bar, $contenance_bouteille, $data, $volume_bouteille);
		
		# Si on trouve un mauvais chiffre, on renvoie une liste vide
		if ($contenance_bouteille < $pression_bouteille*$volume_bouteille*0.1) {
			return array();
		} else {
			return $data;
		}
	}

	public function forwardConsommation($duree, $respiration_moyenne, $evo, $bar, $contenance_bouteille, $data, $volume_bouteille) {
		for ($i = 0; $i < $duree; $i++) {
			$contenance_bouteille -= $respiration_moyenne*$bar;
			$bar += $evo;

			if ($bar >= 1) {
				array_push($data, $this->addStep(round($contenance_bouteille,2), round(($bar-1)*10),round($bar,1), round($contenance_bouteille / $volume_bouteille)));
			}
		}
		return array(round($contenance_bouteille, 2), round($bar, 2), $data);
	}

	public function addStep($contenance_bouteille, $profondeur, $bar, $pression) {
		return ["contenance_bouteille" => $contenance_bouteille, "profondeur" => $profondeur, "bar" => $bar, "pression" => $pression];
	} 						
}


