<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Entity\User;
use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reservation")
 */
class ReservationController extends AbstractController
{    
    
    /**
     * @Route("/", name="reservation_index", methods={"GET"})
     */
    public function index(ReservationRepository $reservationRepository): Response
    {
//         if (!is_object($this->getUser())) {
//             $user_id = null;
//         }
//         else {
//             $user_id = $this->getUser()->getId();
//         }
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAll(), 'sous_titre' => "Vos réservations",
        ]);
    }

    /**
     * @Route("/new", name="reservation_new", methods={"GET","POST"})
     */
    public function new(Request $request, ReservationRepository $reservationRepository): Response
    {
        $reservation = new Reservation();
        $reservation->setClient($this->getUser()->getClient());
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
            
        if ($form->isSubmitted() && $form->isValid()) {
            /* On va regarder si la réservation est compatible avec les réservations déjà faites pour la chambre */
            /* Condition de segments gauche->droite */
            $cond1 = $reservation->getDateDebut() <= $reservation->getDateFin();
            if(!$cond1){
                $this->get('session')->getFlashBag()->add('error', 'La date de début doit être avant la date de fin.');
                return $this->redirectToRoute('reservation_index');
                
            }
            $reservations = $reservationRepository->findBy(['room' => $reservation->getRoom()]);
            foreach ($reservations as $res){
                /* Conditions de non intersection de deux segments de type [i,j] où j>=i */
                $ou1 = $reservation->getDateDebut() <= $res->getDateDebut() && $reservation->getDateFin() <= $res->getDateDebut();
                $ou2 = $reservation->getDateDebut() >= $res->getDateFin();
                $ou = $ou1 || $ou2;
                if (! $ou) {
                    $this->get('session')->getFlashBag()->add('error', 'La chambre est déjà prise à cette date, veuillez choisir une autre date.');
                    return $this->redirectToRoute('reservation_index');
                }
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('reservation_index');
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),'sous_titre' => "Ajouter une réservation",
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_show", methods={"GET"})
     */
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reservation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reservation $reservation): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reservation_index');
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Reservation $reservation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reservation_index');
    }
}
