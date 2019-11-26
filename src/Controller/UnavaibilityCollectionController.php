<?php

namespace App\Controller;

use App\Entity\UnavaibilityCollection;
use App\Form\UnavaibilityCollectionType;
use App\Repository\UnavaibilityCollectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Unavaibility;

/**
 * @Route("/unavaibility/collection")
 */
class UnavaibilityCollectionController extends AbstractController
{
    /**
     * @Route("/", name="unavaibility_collection_index", methods={"GET"})
     */
    public function index(UnavaibilityCollectionRepository $unavaibilityCollectionRepository): Response
    {
        return $this->render('unavaibility_collection/index.html.twig', [
            'unavaibility_collections' => $unavaibilityCollectionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="unavaibility_collection_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $unavaibilityCollection = new UnavaibilityCollection();
        $unavaibility1 = new Unavaibility();
        $unavaibilityCollection->getUnavaibilities()->add($unavaibility1);
        $unavaibility2 = new Unavaibility();
        $unavaibilityCollection->getUnavaibilities()->add($unavaibility2);
        
        $form = $this->createForm(UnavaibilityCollectionType::class, $unavaibilityCollection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($unavaibilityCollection);
            $entityManager->flush();

            return $this->redirectToRoute('unavaibility_collection_index');
        }

        return $this->render('unavaibility_collection/new.html.twig', [
            'unavaibility_collection' => $unavaibilityCollection,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="unavaibility_collection_show", methods={"GET"})
     */
    public function show(UnavaibilityCollection $unavaibilityCollection): Response
    {
        return $this->render('unavaibility_collection/show.html.twig', [
            'unavaibility_collection' => $unavaibilityCollection,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="unavaibility_collection_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UnavaibilityCollection $unavaibilityCollection): Response
    {
        $form = $this->createForm(UnavaibilityCollectionType::class, $unavaibilityCollection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('unavaibility_collection_index');
        }

        return $this->render('unavaibility_collection/edit.html.twig', [
            'unavaibility_collection' => $unavaibilityCollection,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="unavaibility_collection_delete", methods={"DELETE"})
     */
    public function delete(Request $request, UnavaibilityCollection $unavaibilityCollection): Response
    {
        if ($this->isCsrfTokenValid('delete'.$unavaibilityCollection->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($unavaibilityCollection);
            $entityManager->flush();
        }

        return $this->redirectToRoute('unavaibility_collection_index');
    }
}
