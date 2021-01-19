<?php
/*
 * CRUD Table plongée
 * @author ILLIEN Victor
 * 
*/

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;


use App\Entity\Tableplongee;
use App\Entity\Profondeur;
use App\Entity\Temps;

use App\Form\TablePlongeeFormType;

/**
* @Route("/table", name="table_")
*/
class TablePlongeeController extends AbstractController
{
    /**
     * @Route("/show", name="show")
     */
    public function show(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $tablePlongee = $this->getDoctrine()
    		->getRepository(Tableplongee::class)
            ->findAll();
        
        return $this->render('table_plongee/index.html.twig', [
            'tablePlongee' => $tablePlongee,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */

    public function delete(Tableplongee $table): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        # On récupère toutes les profondeurs liés à une table
        $allProfondeur = $this->getDoctrine()
            ->getRepository(Tableplongee::class)
            ->findIdProfondeur($table->getId());

        if (isset($allProfondeur) && $allProfondeur != NULL) {
            
            # Permet de créer une entity depuis un id
            $repository1 = $this->getDoctrine()->getRepository(Profondeur::class);

            # On parcours chaque profondeur pour récupérer tous les temps associés à une profondeur
            foreach($allProfondeur as $value) {
               
                $profondeur = $repository1->find($value['id']);
                
                $allTime = $this->getDoctrine()
                    ->getRepository(Profondeur::class)
                    ->findIdTemps($profondeur->getId());

                    if (isset($allTime) && $allTime != NULL) {

                        $repository2 = $this->getDoctrine()->getRepository(Temps::class);
                        
                        # On supprime chaque temps
                        foreach($allTime as $time){
                            $temps = $repository2->find($time['id']);
                            $entityManager->remove($temps);    
                        }
                    }
                    # Une fois que les temps sont supprimés, on supprime la profondeur
                    $entityManager->remove($profondeur);
            }
        }

        # Enfin, on supprime la table
        $entityManager->remove($table);
        $entityManager->flush();

        return $this->redirectToRoute('table_show');
    }

    /**
     *  @Route("/edit/{id}", name="edit")
     */

     public function edit($id, Request $request): Response
     {
          
        $tableOnePlongee = $this->getDoctrine()
    		->getRepository(Tableplongee::class)
            ->find($id);
        

        $form = $this->createForm(TablePlongeeFormType::class, $tableOnePlongee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tableFormData = $form->getData();
            $tableOnePlongee->setNom($tableFormData->getNom());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('table_show');
        }

        return $this->render('table_plongee/create.html.twig', [
            'table_form' => $form->createView(),
        ]);

     } 

     /**
      *  @Route("/create", name="create")
      */

      public function create(Request $request): Response
      {
        $form = $this->createForm(TablePlongeeFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newTable = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newTable);
            $entityManager->flush();

            return $this->redirectToRoute('table_show');
        }

        return $this->render('table_plongee/create.html.twig', [
            'table_form' => $form->createView(),
        ]);
      }
}
