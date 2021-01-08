<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Tableplongee;

class TablePlongeeController extends AbstractController
{
    /**
     * @Route("/table", name="table_plongee")
     */
    public function index(): Response
    {
        $tablePlongee = $this->getDoctrine()
    		->getRepository(Tableplongee::class)
            ->findAll();
        

        return $this->render('table_plongee/index.html.twig', [
            'tablePlongee' => $tablePlongee,
        ]);
    }

    /**
     * @Route("/table/delete", name="table_delete")
     */

    public function delete() 
    {

    }

    /**
     *  @Route("/table/edit", name="table_edit")
     */

     public function edit()
     {

     } 

     /**
      *  @Route("table/create", name="table_create")
      */

      public function create()
      {
          
      }
}
