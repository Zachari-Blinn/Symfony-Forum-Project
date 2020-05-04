<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Entity\Comment;
use App\Form\TopicType;
use App\Entity\Category;
use App\Entity\HasReadTopic;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\HasReadTopicRepository;
use App\Repository\TopicRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TopicController extends AbstractController
{
    /**
     * @Route("/topic/new/{category}", name="topic_new", methods={"GET","POST"})
     * @Route("/topic/edit/{topic}", name="topic_edit", methods={"GET","POST"})
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
     * @Route("/topic/show/{id}", name="topic_show", methods={"GET","POST"})
     */
    public function show(Topic $topic, Comment $comment = null, HasReadTopicRepository $hasReadTopicRepository, TopicRepository $topicRepository, Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $comment = new Comment($topic);

        $user = $this->getUser();
        $isAuth = false;

        $vues = $topicRepository->findVuesByTopic($topic);

        if($user != null)
        {
            $isAuth = true;
            $comment->setUser($user);
            $hasReadTopic = $hasReadTopicRepository->findOneBy(['user' => $user->getId(), 'topic' => $topic->getId()]);

            if($hasReadTopicRepository->findOneBy(['user' => $user->getId(), 'topic' => $topic->getId()]) == null)
            {
                $hasReadTopic = new HasReadTopic($user, $topic);
            }
            else
            {
                $hasReadTopic->setUpdatedAt(new \DateTime());
            }

            $entityManager->persist($hasReadTopic);
            $entityManager->flush();
        }

        $form = $this->createForm(CommentType::class, $comment, [
            'isAuth' => $isAuth,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($comment);
            $entityManager->flush();

            // $this->addFlash('success', 'Commentaire créée avec succes !');

            return $this->redirectToRoute('topic_show', [
                'id' => $topic->getId(),
            ]);
        }

        return $this->render('topic/show.html.twig', [
            'vues' => $vues,
            'topic' => $topic,
            'form' => $form->createView()
        ]);
    }
}
