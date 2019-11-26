<?php

namespace App\Controller;

use App\Entity\Unavaibility;
use App\Form\UnavaibilityType;
use App\Repository\UnavaibilityRepository;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/unavaibility")
 */
class UnavaibilityController extends AbstractController
{
    /**
     * @Route("/", name="unavaibility_index", methods={"GET"})
     */
    public function index(UnavaibilityRepository $unavaibilityRepository): Response
    {
        return $this->render('unavaibility/index.html.twig', [
            'unavaibilities' => $unavaibilityRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="unavaibility_new", methods={"GET","POST"})
     */
    public function new(Request $request, UnavaibilityRepository $unavaibilityRepository): Response
    {
        $unavaibility = new Unavaibility();
        $form = $this->createForm(UnavaibilityType::class, $unavaibility);
        $form->handleRequest($request);
        /* On sécurise en vérifiant que c'est bien le owner qui ajoute l'indisponibilité */
        if ($this->getUser() == $unavaibility->getRoom()->getOwner()->getUser() && $form->isSubmitted() && $form->isValid()) {
            /* On va regarder si l'indisponibilité est compatible avec les réservations déjà faites pour la chambre */
            /* Condition de segments gauche->droite */
            $cond1 = $unavaibility->getDateDebut() <= $unavaibility->getDateFin();
            if(!$cond1){
                $this->get('session')->getFlashBag()->add('error', 'La date de début doit être antérieure à la date de fin.');
                return $this->redirectToRoute('unavaibility_index');
                
            }
            $unavaibilities = $unavaibilityRepository->findBy(['room' => $unavaibility->getRoom()]);
            foreach ($unavaibilities as $unaiv){
                /* Conditions de non intersection de deux segments de type [i,j] où j>=i */
                $ou1 = $unavaibility->getDateDebut() <= $unaiv->getDateDebut() && $unavaibility->getDateFin() <= $unaiv->getDateDebut();
                $ou2 = $unavaibility->getDateDebut() >= $unaiv->getDateFin();
                $ou = $ou1 || $ou2;
                if (! $ou) {
                    $this->get('session')->getFlashBag()->add('error', 'Vous avez déjà placé une indisponibilité à cette date.');
                    return $this->redirectToRoute('unavaibility_index');
                }
            }
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($unavaibility);
            $entityManager->flush();

            return $this->redirectToRoute('unavaibility_index');
        }

        return $this->render('unavaibility/new.html.twig', [
            'unavaibility' => $unavaibility,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="unavaibility_show", methods={"GET"})
     */
    public function show(Unavaibility $unavaibility): Response
    {
        return $this->render('unavaibility/show.html.twig', [
            'unavaibility' => $unavaibility,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="unavaibility_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Unavaibility $unavaibility, UnavaibilityRepository $unavaibilityRepository): Response
    {
        $form = $this->createForm(UnavaibilityType::class, $unavaibility);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* On va regarder si l'indisponibilité est compatible avec les réservations déjà faites pour la chambre */
            /* Condition de segments gauche->droite */
            $cond1 = $unavaibility->getDateDebut() <= $unavaibility->getDateFin();
            if(!$cond1){
                $this->get('session')->getFlashBag()->add('error', 'La date de début doit être antérieure à la date de fin.');
                return $this->redirectToRoute('reservation_index');
                
            }
            $unavaibilities = $unavaibilityRepository->findBy(['room' => $unavaibility->getRoom()]);
            foreach ($unavaibilities as $unaiv){
                /* Conditions de non intersection de deux segments de type [i,j] où j>=i */
                $ou1 = $unavaibility->getDateDebut() <= $unaiv->getDateDebut() && $unavaibility->getDateFin() <= $unaiv->getDateDebut();
                $ou2 = $unavaibility->getDateDebut() >= $unaiv->getDateFin();
                $ou = $ou1 || $ou2;
                if (! $ou) {
                    $this->get('session')->getFlashBag()->add('error', 'Vous avez déjà placé une indisponibilité à cette date.');
                    return $this->redirectToRoute('reservation_index');
                }
            }
            
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('unavaibility_index');
        }

        return $this->render('unavaibility/edit.html.twig', [
            'unavaibility' => $unavaibility,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="unavaibility_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Unavaibility $unavaibility): Response
    {
        if ($this->isCsrfTokenValid('delete'.$unavaibility->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($unavaibility);
            $entityManager->flush();
        }

        return $this->redirectToRoute('unavaibility_index');
    }
}
