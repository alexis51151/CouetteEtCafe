<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexPageController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home2.html.twig', [
            'welcome' => 'A changer plus tard', 'sous_titre' => 'Nos offres phares',
        ]);
    }
        
}
