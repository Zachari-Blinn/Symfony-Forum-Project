<?php

namespace App\Controller;

use App\Entity\Forum;
use App\Form\ForumType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ForumController extends AbstractController
{
    /**
     * @Route("/forum/new", name="app_forum_new", methods={"GET","POST"})
     * @Route("/forum/edit/{slug}", name="app_forum_edit", methods={"GET","POST"})
     */
    public function newOrEdit(Forum $forum = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if(!$forum) $forum = new Forum();
        
        $form = $this->createForm(ForumType::class, $forum);

        $form->handleRequest($request);

        $slugger = new AsciiSlugger();

        if ($form->isSubmitted() && $form->isValid())
        {
            $forum->setSlug($slugger->slug($forum->getTitle()));

            $entityManager->persist($forum);
            $entityManager->flush();

            $this->addFlash('success', 'Création de Forum avec succes');

            return $this->redirectToRoute('default');
        }

        return $this->render('forum/newOrEdit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
