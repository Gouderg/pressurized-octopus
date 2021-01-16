<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomePageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        return $this->render('home_page/index.html.twig');
    }

    /**
     * @Route("/api/resultForm", methods={"GET"}, name="test")
     */
    public function resultForm(Request $request) {

        // if (!$request->query->get('data') || $request->query->get('data') == '') {
        //     $errors = [
        //         'status' => 404,
        //         'errors' => "Get not found",
        //        ];
        //     $responseError = new JsonResponse($errors);
        //     $responseError->setStatusCode(Response::HTTP_NOT_FOUND); // code 404
        //     //https://github.com/symfony/symfony/blob/5.x/src/Symfony/Component/HttpFoundation/Response.php#L23
        //     return $responseError;
            
        // }
        $api=$_GET;
        var_dump($_GET);
        


        
        // $api = $this->getDoctrine()
        //             ->getRepository(Cours::class)
        //             ->findApiLike($);


        $response = new Response();
        $response->setStatusCode(Response::HTTP_OK); // code 200

        $response->setContent(json_encode($api));
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
       
    }
}
