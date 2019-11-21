<?php

namespace App\Controller;

use App\Entity\Unavaibility;
use App\Form\UnavaibilityType;
use App\Repository\UnavaibilityRepository;
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
    public function new(Request $request): Response
    {
        $unavaibility = new Unavaibility();
        $form = $this->createForm(UnavaibilityType::class, $unavaibility);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
    public function edit(Request $request, Unavaibility $unavaibility): Response
    {
        $form = $this->createForm(UnavaibilityType::class, $unavaibility);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
