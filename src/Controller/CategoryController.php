<?php

namespace App\Controller;

use App\Entity\Forum;
use App\Entity\Topic;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\TopicRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{slug}/{page}", name="app_category")
     */
    public function index(Category $category, TopicRepository $topicRepository, PaginatorInterface $paginator, Request $request, Int $page): Response
    {
        // $data = $topicRepository->findBy([
        //     'category' => $category->getId(),
        // ]);

        $data = $topicRepository->findAllTopicByNewest($category);

        $topics = $paginator->paginate($data, $request->query->getInt('page', $page), 8);

        return $this->render('category/index.html.twig', [
            'category' => $category,
            'topics' => $topics
        ]);
    }

    /**
     * New or edit category entity
     * 
     * @Route("/category/new/{forum}", name="app_category_new", methods={"GET","POST"})
     * @Route("/category/edit/{forum}/{category}", name="app_category_edit", methods={"GET","POST"})
     */
    public function newOrEdit(Forum $forum, Category $category = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        $currentRoute = $request->attributes->get('_route');

        if($currentRoute == "category_new") $category = null;

        if(!$category) $category = new Category($forum);

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        $slugger = new AsciiSlugger();

        if ($form->isSubmitted() && $form->isValid())
        {
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

    /**
     * @Route("/category/delete/{slug}", name="category_delete", methods={"DELETE"})  
     */
    public function deleteParty(Category $category, EntityManagerInterface $entityManager, Request $request): Response
    {
        $this->denyAccessUnlessGranted('delete', $category);

        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token')))
        {
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_default');
    }

}
