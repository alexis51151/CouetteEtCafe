<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Room;
use App\Entity\User;
use App\Form\RoomType;
use App\Repository\RoomRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Security\Core\Security;
use \DateTime;
use Doctrine\Common\Collections\ArrayCollection;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier")
     */
    public function index(RoomRepository $roomRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $rooms = $em->getRepository(Room::class)->findAll();
        $likes = $this->get('session')->get('likes');
        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController', 'rooms' => $rooms, 'likes' => $likes, 'sous_titre' => "Votre panier",
        ]);
    }
}

