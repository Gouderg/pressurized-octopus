<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;


use App\Entity\Tableplongee;
use App\Entity\Profondeur;
use App\Entity\Temps;

use App\Form\ProfondeurType;

/**
* @Route("/profondeur", name="profondeur_")
*/
class ProfondeurController extends AbstractController
{
    /**
     * @Route("/show", name="show")
     */
    public function show(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $profondeurAll = $this->getDoctrine()
            ->getRepository(Profondeur::class)
            ->findAll();

        return $this->render('profondeur/index.html.twig', [
            'profondeurs' => $profondeurAll,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */

    public function delete(Profondeur $profondeur): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        # On récupère toutes les temps liés à une table
        $allTemps = $this->getDoctrine()
            ->getRepository(Profondeur::class)
            ->findIdTemps($profondeur->getId());

        if (isset($allTemps) && $allTemps != NULL) {
            
            # Permet de créer une entity depuis un id
            $repository1 = $this->getDoctrine()->getRepository(Temps::class);

            # On parcours chaque profondeur pour récupérer tous les temps associés à une profondeur
            foreach($allTemps as $value) {
                $temps = $repository1->find($value['id']);
                $entityManager->remove($temps);
            }
        }

        # Enfin, on supprime la profondeur
        $entityManager->remove($profondeur);
        $entityManager->flush();

        return $this->redirectToRoute('profondeur_show');
    }

    /**
     *  @Route("/edit/{id}", name="edit")
     */

     public function edit($id, Request $request): Response
     {
        $oneProf = $this->getDoctrine()
    		->getRepository(Profondeur::class)
            ->find($id);
        

        $form = $this->createForm(ProfondeurType::class, $oneProf);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            
            # Récupération des données du formulaire
            $profFormData = $form->getData();
            

            # On Set les nouvelles valeurs
            $oneProf->setProfondeur($profFormData->getProfondeur());
            $oneProf->setCorrespond($profFormData->getCorrespond());
            
            # On rafraichit la base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($oneProf);
            $entityManager->flush();

            return $this->redirectToRoute('profondeur_show');
        }

        return $this->render('profondeur/create.html.twig', [
            'prof_form' => $form->createView(),
        ]);
     } 

     /**
      *  @Route("/create", name="create")
      */

      public function create(Request $request): Response
      {
        $form = $this->createForm(ProfondeurType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            # Récupération des données du formulaire
            $profFormData = $form->getData();

            # On Set les nouvelles valeurs
            $newProf = new Profondeur();
            $newProf->setProfondeur($profFormData->getProfondeur());
            $newProf->setCorrespond($profFormData->getCorrespond());


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newProf);
            $entityManager->flush();

            return $this->redirectToRoute('profondeur_show');
        }

        return $this->render('profondeur/create.html.twig', [
            'prof_form' => $form->createView(),
        ]);
      }
}
