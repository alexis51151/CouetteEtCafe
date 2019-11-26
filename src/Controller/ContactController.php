<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contact")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/", name="contact_index", methods={"GET"})
     */
    public function index(ContactRepository $contactRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Accès refusé');
        return $this->render('contact/index.html.twig', [
            'contacts' => $contactRepository->findAll(), 'sous-titre' => 'Les messages en attente',
        ]);
    }

    /**
     * @Route("/new", name="contact_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        $user = $this->getUser();
        if ($form->isSubmitted() && $form->isValid()) {
            if($user == null){
                $contact->setAuthor(null);
            }
            else {
                $contact->setAuthor($user);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('contact_index');
        }

        return $this->render('contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contact_show", methods={"GET"})
     */
    public function show(Contact $contact): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Accès refusé');
        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="contact_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Contact $contact): Response
    {
        
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Accès refusé');
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contact_index');
        }

        return $this->render('contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contact_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Contact $contact): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Accès refusé');
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contact_index');
    }
}
