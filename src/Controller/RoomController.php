<?php

namespace App\Controller;

use App\Entity\Room;
use App\Entity\Owner;
use App\Entity\User;
use App\Entity\Client;
use App\Form\CommentaireType;
use App\Form\RoomType;
use App\Entity\Commentaire;
use App\Repository\OwnerRepository;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Security\Core\Security;
use \DateTime;
use Doctrine\Common\Collections\ArrayCollection;
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
        $user = $this->getUser();
        if ($user == null){
            return $this->redirectToRoute('app_login');
        }
        return $this->render('room/index.html.twig', [
            'rooms' => $roomRepository->findAll(), 'sous_titre' => "Vos chambres à louer",
        ]);
    }

    /**
     * @Route("/new", name="room_new", methods={"GET","POST"})
     */
    public function new(Request $request, OwnerRepository $ownerRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Accès refusé, veuillez vous inscrire');
        $room = new Room();
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);
        $user = $this->getUser();
        $owner = $ownerRepository->findBy(['user' => $user]);
        if (empty($owner)) {
            $owner = new Owner();
            $owner->setUser($user);
            $owner->addRoom($room);
        }
        else {
            $owner->addRoom($room);
        }
        $room->setOwner($owner);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($room);
            $entityManager->flush();
            return $this->redirectToRoute('room_index');
        }

        return $this->render('room/new.html.twig', [
            'room' => $room,
            'form' => $form->createView(),
            'sous-titre' => "Créer une nouvelle chambre",
        ]);
    }

    /**
     * @Route("/{id}", name="room_show", methods={"GET","POST"})
     * @ParamConverter("room", class="App\Entity\Room")
     */
    public function show(Request $request, Room $room): Response
    {
        
        # Partie formulaire pour les commentaires en fin de page
        $new_commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $new_commentaire);
        $user = $this->getUser();
        $new_commentaire->setUser($user);
        $new_commentaire->setRoom($room);
        $dt = new DateTime();
        $dt->format('Y-m-d H:i:s');
        $new_commentaire->setDate($dt);
        $form->handleRequest($request);
        $sous_titre = $room->getSummary();
        $commentaires = $room->getCommentaires();
        $nb_commentaires = $commentaires->count();
        if ($form->isSubmitted() && $form->isValid()) {
            $reservations= $room->getReservations();
            $clients = new ArrayCollection();
            foreach($reservations as $reservation){
                $clients[] = $reservation->getClient();
            }
            if ($clients->contains($user->getClient())){
                $this->get('session')->getFlashBag()->add('message', 'Commentaire bien publié');
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($new_commentaire);
                $entityManager->flush();
            }
            else {
                $this->get('session')->getFlashBag()->add('error', 'Vous ne pouvez commenter cette annonce.');
            }
            return $this->redirectToRoute('regions');
        }
        
        return $this->render('room/show.html.twig', [
            'room' => $room, 'sous_titre' => $sous_titre,"nb_commentaires" => $nb_commentaires, "commentaires" => $commentaires, 'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete_commentaire/{id}", name="delete_commentaire", methods={"DELETE"})
     */
    
    public function delete_commentaire(Request $request, Commentaire $comment): Response 
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Accès refusé.');
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }
        
        return $this->redirectToRoute('room_index');
        
        
    }

    /**
     * @Route("/{id}/edit", name="room_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Room $room): Response
    {
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);
        $user = $this->getUser();
        if ($user == null ||( (!in_array('ROLE_ADMIN',$user->getRoles())) && $room->getOwner() != $user->getOwner()) ){
            return $this->redirectToRoute('app_login');
            
        }
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
        $user = $this->getUser();
        if ($user == null || ( (!in_array('ROLE_ADMIN',$user->getRoles())) && $room->getOwner() != $user->getOwner())){
            return $this->redirectToRoute('app_login');
        }
        if ($room->getOwner() == $user->getOwner()  && $this->isCsrfTokenValid('delete'.$room->getId(), $request->request->get('_token'))) {
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
