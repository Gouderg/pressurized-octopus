<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/api/resultForm", methods={"POST"}, name="test")
     */
    public function resultForm(Request $request) {
        var_dump($request->query->get('test'));
    }
}
