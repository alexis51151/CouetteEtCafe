<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\CommentaireType;
use App\Form\RoomType;
use App\Entity\Commentaire;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * @Route("/room")
 */
class RoomController extends AbstractController
{
    /**
     * @Route("/", name="room_index", methods={"GET"})
     */
    public function index(RoomRepository $roomRepository): Response
    {
        return $this->render('room/index.html.twig', [
            'rooms' => $roomRepository->findAll(), 
        ]);
    }

    /**
     * @Route("/new", name="room_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $room = new Room();
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($room);
            $entityManager->flush();

            return $this->redirectToRoute('room_index');
        }

        return $this->render('room/new.html.twig', [
            'room' => $room,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="room_show", methods={"GET", "POST"})
     * @ParamConverter("room", class="App\Entity\Room")
     */
    public function show(Request $request, Room $room): Response
    {
        # Partie formulaire pour les commentaires en fin de page
        $new_commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $new_commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            
            return $this->redirectToRoute('room_show');
        }
        
        # Fin partie formulaire
        $sous_titre = $room->getSummary();
        $commentaires = $room->getCommentaires();
        $nb_commentaires = $commentaires->count();
        return $this->render('room/show.html.twig', [
            'room' => $room, 'sous_titre' => $sous_titre,"nb_commentaires" => $nb_commentaires, "commentaires" => $commentaires,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="room_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Room $room): Response
    {
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('room_index');
        }

        return $this->render('room/edit.html.twig', [
            'room' => $room,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="room_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Room $room): Response
    {
        if ($this->isCsrfTokenValid('delete'.$room->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($room);
            $entityManager->flush();
        }

        return $this->redirectToRoute('room_index');
    }
    
    
    /**
     * @Route("/{id_room}/{id_region}/likes", name="likes")
     */
    public function addLike(string $id_room, string $id_region){
        $likes = $this->get('session')->get('likes');
        if (is_null($likes)){
            $likes[] = $id_room;
        }
        else {
            if (! in_array($id_room, $likes)) {
                $likes[] = $id_room;
            }
            else {
                $likes = array_diff($likes, array($id_room));
            }
        }
        $this->get('session')->set('likes',$likes);
        return $this->redirectToRoute('region_announces', ['id_region' => $id_region]);
        
    }
}
