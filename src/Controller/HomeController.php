<?php

namespace App\Controller;


use App\Entity\Offer;
use App\Form\ChangePasswordType;
use App\Repository\OfferRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/offers", name="app_list_offers")
     */
    public function offers(OfferRepository $offerRepository): Response
    {
        $offers = $offerRepository->findAll();
        return $this->render('home/offers.html.twig', [
            'offers' => $offers
        ]);
    }


    /**
     * @Route("/companies", name="app_list_companies")
     */
    public function companies(UserRepository $userRepository): Response
    {
        $companies = $userRepository->findCompanies();
        return $this->render('home/companies.html.twig', [
            'companies' => $companies
        ]);
    }

    /**
     * @Route("/profile/change-password", methods={"GET", "POST"}, name="app_profile_change_password")
     */
    public function changePassword(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($userPasswordHasher->hashPassword($user, $form->get('plainPassword')->getData()));
            $entityManager->flush();
            $this->addFlash('success', 'Mot de passe chang??');

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profile/change_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{offer}/postuler", name="app_offer_user")
     * @IsGranted("ROLE_STUDENT")
     */
    public function postuler(Offer $offer, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $offer->addCandidate($user);
        $entityManager->flush();
        $this->addFlash('success', 'Votre demande bien ajout??');
        return $this->redirectToRoute('app_candidate', [], Response::HTTP_SEE_OTHER);
    }
}
