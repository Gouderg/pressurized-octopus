<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use App\Entity\Temps;
use App\Form\TempsType;

/**
 *  @Route("/temps", name="temps_")
 */

class TempsController extends AbstractController
{
    /**
     * @Route("/show", name="show")
     */
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $tempsAll = $this->getDoctrine()
            ->getRepository(Temps::class)
            ->findAll();

        return $this->render('temps/index.html.twig', [
            'temps' => $tempsAll,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */

    public function delete(Temps $temps): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($temps);
        $entityManager->flush();
        return $this->redirectToRoute('temps_show');
     }

    /**
     *  @Route("/edit/{id}", name="edit")
     */

    public function edit($id, Request $request): Response
    {
        $oneTemps = $this->getDoctrine()
    		->getRepository(Temps::class)
            ->find($id);
        

        $form = $this->createForm(TempsType::class, $oneTemps);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            # Récupération des données du formulaire
            $tempsFormData = $form->getData();

            # On Set les nouvelles valeurs
            $oneTemps->setTemps($tempsFormData->getTemps());
            $oneTemps->setPalier15($tempsFormData->getPalier15());
            $oneTemps->setPalier12($tempsFormData->getPalier12());
            $oneTemps->setPalier9($tempsFormData->getPalier9());
            $oneTemps->setPalier6($tempsFormData->getPalier6());
            $oneTemps->setPalier3($tempsFormData->getPalier3());
            $oneTemps->setEstA($tempsFormData->getEstA());

            
            # On rafraichit la base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($oneTemps);
            $entityManager->flush();

            return $this->redirectToRoute('temps_show');
        }

        return $this->render('temps/create.html.twig', [
            'temps_form' => $form->createView(),
        ]);
    } 

    /**
    *  @Route("/create", name="create")
    */

    public function create(Request $request): Response
    {   

        $form = $this->createForm(TempsType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            # Récupération des données du formulaire
            $tempsFormData = $form->getData();

            # On Set les nouvelles valeurs
            $oneTemps = new Temps();
            $oneTemps->setTemps($tempsFormData->getTemps());
            $oneTemps->setPalier15($tempsFormData->getPalier15());
            $oneTemps->setPalier12($tempsFormData->getPalier12());
            $oneTemps->setPalier9($tempsFormData->getPalier9());
            $oneTemps->setPalier6($tempsFormData->getPalier6());
            $oneTemps->setPalier3($tempsFormData->getPalier3());
            $oneTemps->setEstA($tempsFormData->getEstA());

            
            # On rafraichit la base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($oneTemps);
            $entityManager->flush();

            return $this->redirectToRoute('temps_show');
        }

        return $this->render('temps/create.html.twig', [
            'temps_form' => $form->createView(),
        ]); 
    }
}
