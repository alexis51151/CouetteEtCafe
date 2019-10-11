<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Region;
use App\Entity\Room;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class RegionAnnouncesController extends AbstractController
{
    /**
     * @Route("/region/{id_region}", name="region_announces")
     */
    
    public function index(string $id_region)
    {
        $em = $this->getDoctrine()->getManager();
        $region = $em->getRepository(Region::class)->find($id_region);
        $rooms = $em->getRepository(Room::class)->findAll();
        return $this->render('region_announces/index.html.twig', [
            'rooms' => $rooms, 'region' => $region,
        ]);
    }
}
