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
     * @Route("/category/{slug}", name="category")
     */
    public function index(Category $category, TopicRepository $topicRepository)
    {
        return $this->render('category/index.html.twig', [
            'category' => $category,
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

        if(!$category) $category = new Category($forum);

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        $slugger = new AsciiSlugger();

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();

            $category->setSlug($slugger->slug($category->getTitle()));

            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', 'Category créée avec succes !');

            return $this->redirectToRoute('default');
        }

        return $this->render('category/newOrEdit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
