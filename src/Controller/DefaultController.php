<?php

namespace App\Controller;

use Twig\Environment;
use App\Repository\ForumRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_default")
     */
    public function index(ForumRepository $forumRepository)
    {
        return $this->render('default/index.html.twig', [
            'forums' => $forumRepository->findAll()
        ]);
    }

    /**
     * @Route("/admin", name="app_admin")
     */
    public function admin()
    {
        return new Response('<html><body>Admin page!</body></html>');
    }

}
