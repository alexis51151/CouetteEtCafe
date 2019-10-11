<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Region;

class GetRegionsController extends AbstractController
{
    /**
     * @Route("/regions", name="regions")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $regions = $em->getRepository(Region::class)->findAll();
        
        return $this->render('get_regions/index.html.twig', [
            'regions' => $regions,
        ]);
    }
}
