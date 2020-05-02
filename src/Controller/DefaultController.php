<?php

namespace App\Controller;

use App\Repository\ForumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(ForumRepository $forumRepository)
    {
        return $this->render('default/index.html.twig', [
            'forums' => $forumRepository->findAll()
        ]);
    }

}
