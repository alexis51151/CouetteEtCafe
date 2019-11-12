<?php

namespace App\Controller;

use App\Entity\Unavailabilities;
use App\Form\UnavailabilitiesType;
use App\Repository\UnavailabilitiesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/unavailabilities")
 */
class UnavailabilitiesController extends AbstractController
{
    /**
     * @Route("/", name="unavailabilities_index", methods={"GET"})
     */
    public function index(UnavailabilitiesRepository $unavailabilitiesRepository): Response
    {
        return $this->render('unavailabilities/index.html.twig', [
            'unavailabilities' => $unavailabilitiesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="unavailabilities_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $unavailability = new Unavailabilities();
        $form = $this->createForm(UnavailabilitiesType::class, $unavailability);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($unavailability);
            $entityManager->flush();

            return $this->redirectToRoute('unavailabilities_index');
        }

        return $this->render('unavailabilities/new.html.twig', [
            'unavailability' => $unavailability,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="unavailabilities_show", methods={"GET"})
     */
    public function show(Unavailabilities $unavailability): Response
    {
        return $this->render('unavailabilities/show.html.twig', [
            'unavailability' => $unavailability,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="unavailabilities_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Unavailabilities $unavailability): Response
    {
        $form = $this->createForm(UnavailabilitiesType::class, $unavailability);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('unavailabilities_index');
        }

        return $this->render('unavailabilities/edit.html.twig', [
            'unavailability' => $unavailability,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="unavailabilities_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Unavailabilities $unavailability): Response
    {
        if ($this->isCsrfTokenValid('delete'.$unavailability->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($unavailability);
            $entityManager->flush();
        }

        return $this->redirectToRoute('unavailabilities_index');
    }
}
