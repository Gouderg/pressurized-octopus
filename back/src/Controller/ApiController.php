<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Profondeur;
use App\Entity\Tableplongee;
use App\Entity\Temps;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;


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
    /*

        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
        */
        //return new JsonResponse($profondeurs);
        $response = new Response();
        
        $response->setContent(json_encode($profondeurs));
		$response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
        //$response = 

	}

	public function listTable()
	{
		$Tables =$this->getDoctrine()
                    ->getRepository(Tableplongee::class)
                    ->findApiAll();
    /*

        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
        */
        //return new JsonResponse($profondeurs);
        $response = new Response();
        
        $response->setContent(json_encode($Tables));
		$response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
        //$response = 

	}

	public function listTemps()
	{
		$tmp =$this->getDoctrine()
                    ->getRepository(Temps::class)
                    ->findApiAll();
    /*

        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
        */
        //return new JsonResponse($profondeurs);
        $response = new Response();
        
        $response->setContent(json_encode($tmp));
		$response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
        //$response = 

	}
    
}

