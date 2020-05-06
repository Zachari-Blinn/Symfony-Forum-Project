<?php

namespace App\Controller;

use App\Entity\Forum;
use App\Entity\Topic;
use App\Entity\Category;
use App\Form\CategoryType;
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
    public function index(Category $category, PaginatorInterface $paginator, Request $request, $page): Response
    {
        $data = $this->getDoctrine()->getRepository(Topic::class)->findBy([
            'category' => $category->getId(),
        ]);

        $topics = $paginator->paginate(
            $data, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', $page), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            8 // Nombre de résultats par page
        );

        return $this->render('category/index.html.twig', [
            'category' => $category,
            'topics' => $topics
        ]);
    }

    /**
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
}
