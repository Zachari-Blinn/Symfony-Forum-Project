<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Entity\Comment;
use App\Form\TopicType;
use App\Entity\Category;
use App\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TopicController extends AbstractController
{
    /**
     * @Route("/topic/new/{category}", name="app_topic_new", methods={"GET","POST"})
     * @Route("/topic/edit/{topic}", name="app_topic_edit", methods={"GET","POST"})
     */
    public function newOrEdit(Category $category = null, Topic $topic = null, Request $request): Response
    {
        $currentRoute = $request->attributes->get('_route');

        if($currentRoute == "topic_new") $topic = null;

        if(!$topic) $topic = new Topic($category);
        
        $form = $this->createForm(TopicType::class, $topic);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($topic);
            $entityManager->flush();

            // $this->addFlash('success', 'Topic créée avec succes !');

            return $this->redirectToRoute('default');
        }

        return $this->render('topic/newOrEdit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/topic/show/{id}", name="app_topic_show", methods={"GET","POST"})
     */
    public function show(Topic $topic, Comment $comment = null, Request $request): Response
    {
        $comment = new Comment($topic);

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($comment);
            $entityManager->flush();

            // $this->addFlash('success', 'Commentaire créée avec succes !');

            return $this->redirectToRoute('topic_show', [
                'id' => $topic->getId(),
            ]);
        }

        return $this->render('topic/show.html.twig', [
            'topic' => $topic,
            'form' => $form->createView()
        ]);
    }
}
