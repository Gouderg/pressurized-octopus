<?php
/*
 * Contient tous les requêtes qui communiquent avec le front
 * @author PRALAIN Léopold - ILLIEN Victor
 * 
*/
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use App\Entity\Profondeur;
use App\Entity\Tableplongee;
use App\Entity\Temps;
use App\Validator\ApiInputValidator;
use App\Validator\ApiInput;



/**
* @Route("/api", name="api")
*/
class ApiController extends AbstractController
{

	/**
     * @Route("/tables/show/{id}", name="show_choix")
     */
	public function choix($id) {

		// On vérifie si la valeur passée en paramètre est valide
		if (!is_numeric($id) || $id == 0 || $id >2 ) {
            $data = [
                'status' => 404,
                'errors' => "Wrong numb for table use 1 or 2 only ( 1: Bulhman, 2:MN90) ",
               ];
            return new JsonResponse($data);
     	}

		// On récupère le contenu de la table souhaitée
		$tb = $this->getDoctrine()
                    ->getRepository(Tableplongee::class)
                    ->findTables($id);
		
		// On parse la donnée pour l'affichage
		$oldprof = 0;
		$data = [];
		$temp = [];


		foreach($tb as $key => $value) {
			if ($value['profondeur'] == $oldprof) {
				$oldprof = array_shift($value);
				array_push($temp, $value);
			} else {
				$data[$oldprof] = $temp;
				$oldprof = array_shift($value);
				$temp = [];
				array_push($temp, $value);
			}
		}
		unset($data[0]);

        $response = new Response();
        $response->setContent(json_encode($data));
		$response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;

	}


	/**
     * @Route("/calc", methods={"GET"}, name="calc")
     */
	public function main_calcul_plongee(Request $request){
		
		# On récupère la réponse
		$api = [];
		foreach($_GET as $key => $value) {
			$validator = new ApiInputValidator();
			$message = new ApiInput();
			$temp = $validator->validate($value, $message);
			if ($temp) {
				$api[$key] = $temp;
			} else {
				$errors = [
					'status' => 404,
					'errors' => "Get not found",
					];
				$responseError = new JsonResponse($errors);
				$responseError->setStatusCode(Response::HTTP_NOT_FOUND); // code 404
				return $responseError;
			}
		}

		// Zone de saisie utilisateur
		$table_plonge = $api["tableplonge"];
		$pression_bouteille = $api["pressionbout"];
		$volume_bouteille = $api["volumebout"];
		$profondeur = $api["profondeur"];
		$duree_plongee = $api["temps"];

		// Constante
		$vitesse_descente = 1/3;

		// On regarde si la profondeur existe dans la table de plongée et ainsi que le temps
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

		// Tant que notre fonction ne nous renvoie pas un résultat de plongée réalisable on diminue les paramètres
		while (1) {
			$data = $this->calcul_plongee($profondeur, $duree_plongee, $pression_bouteille, $volume_bouteille, $palier);
			if (empty($data)) {
				$tempPalier = $this->getDoctrine()->getRepository(Temps::class)->dbRequestBeforeTemps($table_plonge, $profondeur, $palier['temps']);
				if (empty($tempPalier)) {
					$tempProfondeur = $this->getDoctrine()->getRepository(Profondeur::class)->dbRequestBeforeProf($table_plonge, $profondeur);
					if (empty($tempProfondeur)) {
						$palier = ['temps' => $duree_plongee, "palier15" => 0, "palier12" => 0, "palier9" => 0, "palier6" => 0, "palier3" => 0];
					} else {
						$profondeur = $tempProfondeur[0]["profondeur"];
						$temps_au_fond = (($duree_plongee * 60) - ($profondeur/$vitesse_descente)) / 60;
						$tempPalier = $this->getDoctrine()->getRepository(Temps::class)->dbRequestNextSupTemps($table_plonge, $profondeur, $temps_au_fond);
						if (empty($tempPalier)) {
							$palier = $this->getDoctrine()->getRepository(Temps::class)->dbRequestLastTemps($table_plonge, $profondeur)[0];
						} else {
							$palier = $tempPalier[0];
						}
					}
					
				} else {
					$palier = $tempPalier[0];
				}
			} else {
				break;
			}
		}
		$data["palier"] = $palier;
		$data["profondeur"] = $profondeur;
		$data["temps_init"] = $palier['temps'];

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
		$timeUnderWater = 0;

		# On cherche le temps de la descente
		$temps_descente = $profondeur / $vitesse_descente;
		$evo_bar = $evolution_bar * $vitesse_descente;

		# Descente
		list($contenance_bouteille, $bar) = $this->forwardConsommation($temps_descente, $respiration_moyenne, $evo_bar, $bar, $contenance_bouteille);
		$timeUnderWater += $temps_descente;
		
		# Temps au fond de l'eau
		$duree_au_fond = $palierUnparse["temps"] * 60 - $temps_descente;
		list($contenance_bouteille, $bar) = $this->forwardConsommation($duree_au_fond, $respiration_moyenne, 0, $bar, $contenance_bouteille);
		$timeUnderWater += $duree_au_fond;

		$data["vbAvantRemonte"] = round($contenance_bouteille,1);
		$data["pbAvantRemonte"] = round($contenance_bouteille/$volume_bouteille,1);

		# On parse les paliers avant de continuer
		$palier = [[15,$palierUnparse["palier15"]], [12,$palierUnparse["palier12"]], [9,$palierUnparse["palier9"]], [6,$palierUnparse["palier6"]], [3,$palierUnparse["palier3"]]];
		
		$isVisited = FALSE;
		$timeUnderWaterRemonte = 0;
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
				list($contenance_bouteille, $bar) = $this->forwardConsommation($timeProfToParcours, $respiration_moyenne, -$evo_bar, $bar, $contenance_bouteille, $data);
				$timeUnderWaterRemonte += $timeProfToParcours;

				# Attente au palier
				list($contenance_bouteille, $bar) = $this->forwardConsommation($elt[1]*60, $respiration_moyenne, 0, $bar, $contenance_bouteille);
				$timeUnderWaterRemonte += $elt[0]*60;

				$isVisited = TRUE;
			}
		}

		# On parcours la distance restante pour remontée à la surface
		if ($isVisited) {
			list($contenance_bouteille, $bar) = $this->forwardConsommation($profondeur/$vitesse_remonte_entre_pallier, $respiration_moyenne, -$evo_bar, $bar, $contenance_bouteille);
			$timeUnderWaterRemonte += $profondeur/$vitesse_remonte_entre_pallier;
		} else {
			list($contenance_bouteille, $bar) = $this->forwardConsommation($profondeur/$vitesse_remonte_avant_pallier, $respiration_moyenne, -$evo_bar, $bar, $contenance_bouteille);
			$timeUnderWaterRemonte += $profondeur/$vitesse_remonte_avant_pallier;
		}
		
		# Si on trouve un mauvais chiffre, on renvoie une liste vide
		if ($contenance_bouteille < $pression_bouteille*$volume_bouteille*0.1) {
			return array();
		} else {
			$data["dtr"] = round(($timeUnderWaterRemonte / 60),1);
			$data["dtp"] = round(($timeUnderWaterRemonte + $timeUnderWater) / 60, 1);
			$data["vbApresRemonte"] = round($contenance_bouteille,1);
			$data["pbApresRemonte"] = round($contenance_bouteille/$volume_bouteille,1);
			return $data;
		}
	}

	// Calcul à chaque seconde la quantité d'air et la pression
	public function forwardConsommation($duree, $respiration_moyenne, $evo, $bar, $contenance_bouteille) {
		for ($i = 0; $i < $duree; $i++) {
			$contenance_bouteille -= $respiration_moyenne*$bar;
			$bar += $evo;
		}
		return array(round($contenance_bouteille, 2), round($bar, 2));
	}			
}


