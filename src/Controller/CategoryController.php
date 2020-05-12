<?php

namespace App\Controller;

use App\Entity\Forum;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\TopicRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{slug}/{page}", name="app_category", requirements={"page"="\d+"}, methods={"GET"})
     */
    public function index(Category $category, TopicRepository $topicRepository, PaginatorInterface $paginator, Request $request, Int $page = 1, CategoryRepository $categoryRepository, UserRepository $userRepository): Response
    {
        $data = $topicRepository->findAllTopicByNewest($category);

        $topics = $paginator->paginate($data, $request->query->getInt('page', $page), 8);

        return $this->render('category/index.html.twig', [
            'category' => $category,
            'topics' => $topics
        ]);
    }

    /**
     * @ParamConverter("slug", options={"mapping": {"forum_slug": "slug"}})
     * @ParamConverter("category", options={"mapping": {"category_slug": "slug"}})
     * 
     * @Route("/category/new/{slug}", name="app_category_new", methods={"GET","POST"})
     * @Route("/category/edit/{forum}/{category}", name="app_category_edit", methods={"GET","POST"})
     */
    public function newOrEdit(Forum $forum, ?Category $category, Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_EDIT_CATEGORY', $category);

        $currentRoute = $request->attributes->get('_route');

        if($currentRoute == "app_category_new")
        {
            $category = null;
            $category = new Category($forum);
        }

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        $slugger = new AsciiSlugger();

        if ($form->isSubmitted() && $form->isValid())
        {
            $category->setSlug($slugger->slug($category->getTitle()));

            $entityManager->persist($category);
            $entityManager->flush();

            // $this->addFlash('success', 'Category créée avec succes !');

            return $this->redirectToRoute('app_default');
        }

        return $this->render('category/newOrEdit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/category/delete/{slug}", name="app_category_delete", methods={"DELETE"})  
     */
    public function deleteCategory(Category $category, EntityManagerInterface $entityManager, Request $request): Response
    {
        $this->denyAccessUnlessGranted('delete', $category);

        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token')))
        {
            $category->getTopic()->clear();

            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_default');
    }
}
