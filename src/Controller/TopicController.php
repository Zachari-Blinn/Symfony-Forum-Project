<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Form\TopicType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TopicController extends AbstractController
{
    /**
     * @Route("/topic", name="topic")
     */
    public function index()
    {
        return $this->render('topic/index.html.twig', [
            'controller_name' => 'TopicController',
        ]);
    }

    /**
     * @Route("/topic/new", name="topic_new", methods={"GET","POST"})
     * @Route("/topic/edit/{id}", name="topic_edit", methods={"GET","POST"})
     */
    public function newOrEdit(Topic $topic = null, Request $request): Response
    {
        if(!$topic) $topic = new Topic();
        
        $form = $this->createForm(TopicType::class, $topic);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($topic);
            $entityManager->flush();

            $this->addFlash('success', 'Topic créée avec succes !');

            return $this->redirectToRoute('topic');
        }

        return $this->render('topic/newOrEdit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
