<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Room;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class RegionAnnouncesController extends AbstractController
{
    /**
     * @Route("/region/{id}", name="region_announces")
     */
    
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        
        $rooms = $em->getRepository(Room::class)->findAll();
        return $this->render('region_announces/index.html.twig', [
            'rooms' => $rooms,
        ]);
    }
}
