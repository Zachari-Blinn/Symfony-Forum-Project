<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Entity\Comment;
use App\Form\TopicType;
use App\Entity\Category;
use App\Form\CommentType;
use App\Entity\HasReadTopic;
use App\Repository\TopicRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\HasReadTopicRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TopicController extends AbstractController
{
    /**
     * @Route("/topic/show/{id}/{page}", name="app_topic_show", methods={"GET","POST"})
     */
    public function show(Topic $topic, Comment $comment = null, HasReadTopicRepository $hasReadTopicRepository, TopicRepository $topicRepository, PaginatorInterface $paginator, Request $request, $page, EntityManagerInterface $entityManager): Response
    {
        $comment = new Comment($topic);

        $form = $this->createForm(CommentType::class, $comment);
        $user = $this->getUser();
        $isAuth = false;

        $views = $topicRepository->findViewsByTopic($topic);

        $data = $this->getDoctrine()->getRepository(Comment::class)->findBy([
            'topic' => $topic->getId(),
        ]);
        
        $comments = $paginator->paginate($data, $request->query->getInt('page', $page), 18);

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
            'views' => $views,
            'topic' => $topic,
            'comments' => $comments,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/topic/new/{category}", name="app_topic_new", methods={"GET","POST"})
     * @Route("/topic/edit/{topic}", name="app_topic_edit", methods={"GET","POST"})
     */
    public function newOrEdit(Category $category = null, Topic $topic = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        $currentRoute = $request->attributes->get('_route');

        if($currentRoute == "topic_new") $topic = null;

        if(!$topic) $topic = new Topic($category);
        
        $form = $this->createForm(TopicType::class, $topic);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($topic);
            $entityManager->flush();

            // $this->addFlash('success', 'Topic créée avec succes !');

            return $this->redirectToRoute('default');
        }

        return $this->render('topic/newOrEdit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
