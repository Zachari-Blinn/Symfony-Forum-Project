<?php

namespace App\Controller;

use DateTime;
use App\Entity\Party;
use App\Form\PartyType;
use App\Entity\Participate;
use App\Form\ParticipateType;
use App\Repository\PartyRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ParticipateRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PartyController extends AbstractController
{
    /**
     * @Route("/party", name="app_party")
     */
    public function index(PartyRepository $partyRepository)
    {
        return $this->render('party/index.html.twig', [
            'party' => $partyRepository,
        ]);
    }

    /**
     * @Route("/party/new", name="app_party_new", methods={"GET","POST"})
     * @Route("/party/edit", name="app_party_edit", methods={"GET","POST"})
     */
    public function newOrEdit(Party $party = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if(!$party) $party = new Party();

        $form = $this->createForm(PartyType::class, $party);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($party);
            $entityManager->flush();

            return $this->redirectToRoute('app_default');
        }

        return $this->render('party/newOrEdit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/party/show/{slug}", name="app_party_show", methods={"GET","POST"})
     */
    public function show(Party $party): Response
    {
        return $this->render('party/newOrEdit.html.twig', [
            'party' => $party,
        ]);
    }

    /**
     * New or edit participate at party
     * 
     * @Route("/party/participate/new/{party}", name="app_party_participate", methods={"GET","POST"})
     * @Route("/party/participate/edit/{party}", name="app_party_participate", methods={"GET","POST"})
     */
    public function participate(Party $party, ParticipateRepository $participateRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $currentUser = $this->getUser();
        $auth = false;
        $participate = null;

        if($party->getIsAtive() == false || new \DateTime('now') > $party->getExpireAt() || new \DateTime('now') > $party->getPartyAt())
        {
            throw $this->createNotFoundException('Désolé, vous ne pouvez pas rejoindre cette partie');
        }
        if($party->getAllowAnonymous() == false && $currentUser == null)
        {
            return $this->redirectToRoute('app_login');
        }

        if($currentUser)
        {
            $auth = true;
            $participate = $participateRepository->findOneBy(['party' => $party->getId(), 'user' => $currentUser->getId()]);
        }
        
        if(!$participate) $participate = new Participate($party, $currentUser);
        
        $form = $this->createForm(ParticipateType::class, $participate, ['auth' => $auth]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if($party->getIsAtive() == false || new \DateTime('now') > $party->getExpireAt() || new \DateTime('now') > $party->getPartyAt())
            {
                throw $this->createNotFoundException('Désolé, vous ne pouvez plus rejoindre cette partie');
            }

            $entityManager->persist($participate);
            $entityManager->flush();

            return $this->redirectToRoute('app_default');
        }

        return $this->render('party/participate.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
