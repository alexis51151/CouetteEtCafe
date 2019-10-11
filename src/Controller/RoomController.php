<?php

namespace App\Controller;

use App\Entity\Room;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{
    /**
     * @Route("/room/{id_room}", name="room")
     */
    public function index(string $id_room)
    {
        $em = $this->getDoctrine()->getManager();
        
        $room = $em->getRepository(Room::class)->find($id_room);
        $commentaires = $em->getRepository(Commentaire::class)
        return $this->render('room/index.html.twig', [
            'room' => $room,
        ]);
    }
}
