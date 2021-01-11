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
	/**
     * @Route("/temps", name="temps")
     */

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

	/**
     * @Route("/tables/show/{id}", name="show_choix")
     */

	public function choix($id)
	{
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


        
    /*

        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
        */
        //return new JsonResponse($profondeurs);
        $response = new Response();
        
        $response->setContent(json_encode($tb));
		$response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
        //$response = 

	}
    
}

