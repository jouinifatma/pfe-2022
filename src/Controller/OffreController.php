<?php

namespace App\Controller;
use App\Entity\Offre;
use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OffreController extends AbstractController
{
    /**
     * @Route("/offre", name="app_offre")
     */
    public function index(): Response
    {
        return $this->render('offre/index.html.twig', [
            'controller_name' => 'OffreController',
        ]);
    }
      /**
     * @Route("/offre", name="app_offre")
     */
    public function offre(OffreRepository $offreRepository): Response
    {
        return $this->render('home/offre.html.twig', [
            'offres' => $offreRepository->findAll(),
        ]);
    }
}
