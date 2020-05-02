<?php

namespace App\Controller;

use App\Entity\Forum;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\TopicRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{id}", name="category")
     */
    public function index(Category $category, TopicRepository $topicRepository)
    {
        //on recup tous les sujets de la categorie
        $topics = $topicRepository->findAll([
            'id' => $category->getId()
        ]);

        return $this->render('category/index.html.twig', [
            'category' => $category,
            'topics' => $topics
        ]);
    }

    /**
     * @Route("/category/new/{forum}", name="category_new", methods={"GET","POST"})
     * @Route("/category/edit/{forum}/{category}", name="category_edit", methods={"GET","POST"})
     */
    public function newOrEdit(Forum $forum, Category $category = null, Request $request): Response
    {
        $currentRoute = $request->attributes->get('_route');

        if($currentRoute == "category_new") $category = null;

        if(!$category) $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        $slugger = new AsciiSlugger();

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();

            $category->setSlug($slugger->slug($category->getTitle()));

            if($category->getForum() == null) $category->setForum($forum);

            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', 'Category créée avec succes !');

            return $this->redirectToRoute('default');
        }
        else
        {
            $this->addFlash('danger', 'Une erreur est survenue :(');
        }

        return $this->render('category/newOrEdit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
