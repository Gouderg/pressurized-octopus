<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;


use App\Entity\Tableplongee;
use App\Form\TablePlongeeFormType;

class TablePlongeeController extends AbstractController
{
    /**
     * @Route("/table", name="table_plongee")
     */
    public function index(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $tablePlongee = $this->getDoctrine()
    		->getRepository(Tableplongee::class)
            ->findAll();
        
        
        $form = $this->createForm(TablePlongeeFormType::class);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $newTable = $form->getData();
            $entityManager->persist($newTable);
            $entityManager->flush();

            return $this->redirectToRoute('table_plongee');
        }
        

        return $this->render('table_plongee/index.html.twig', [
            'tablePlongee' => $tablePlongee,
            'table_form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/table/delete/{id}", name="table_delete")
     */

    public function delete(Tableplongee $table) 
    {
        if (!$table) {
            throw $this->createNotFoundException(
                'No table found'
            );
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($table);
        $entityManager->flush();

        return $this->redirectToRoute('table_plongee');
    }

    /**
     *  @Route("/table/edit/{id}", name="table_edit")
     */

     public function edit($id, Request $request)
     {
        
        $tableOnePlongee = $this->getDoctrine()
    		->getRepository(Tableplongee::class)
            ->find($id);
        
        $tablePlongee = $this->getDoctrine()
    		->getRepository(Tableplongee::class)
            ->findAll();

        $form = $this->createForm(TablePlongeeFormType::class, $tableOnePlongee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tableFormData = $form->getData();
            $tableOnePlongee->setNom($tableFormData->getNom());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('table_plongee');
        }

        return $this->render('table_plongee/index.html.twig', [
            'tablePlongee' => $tablePlongee,
            'table_form' => $form->createView(),
        ]);

     } 

     /**
      *  @Route("table/create", name="table_create")
      */

      public function create()
      {
          
      }
}
