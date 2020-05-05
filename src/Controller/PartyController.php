<?php

namespace App\Controller;

use App\Entity\Party;
use App\Form\PartyType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PartyController extends AbstractController
{
    /**
     * @Route("/party", name="party")
     */
    public function index()
    {
        return $this->render('party/index.html.twig', [
            'controller_name' => 'PartyController',
        ]);
    }

    /**
     * @Route("/party/new", name="party_new", methods={"GET","POST"})
     * @Route("/party/edit", name="party_edit", methods={"GET","POST"})
     */
    public function newOrEdit(Party $party = null, Request $request): Response
    {
        if(!$party) $party = new Party();

        $form = $this->createForm(PartyType::class, $party);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($party);
            $entityManager->flush();
        }

        return $this->render('party/newOrEdit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/party/show/{slug}", name="party_show", methods={"GET","POST"})
     */
    public function show(): Response
    {
        return $this->render('party/newOrEdit.html.twig', [
        ]);
    }
}
