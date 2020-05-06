<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="app_user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
        ]);
    }

    /**
     * @Route("/user/profil/show/{slug}", name="app_user_profil_show")
     */
    public function showProfil(User $user)
    {
        return $this->render('user/show.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/user/profil/edit/{pseudo}", name="app_user_profil_edit", methods={"GET","POST"})
     */
    public function editProfil(User $user, Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProfilType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $imageFile = $form->get('image')->getData();

            if($imageFile)
            {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);

                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try
                {
                    $imageFile->move($this->getParameter('profil_image_directory'), $newFilename);
                }
                catch (FileException $e)
                {
                    // todo error
                }

                $user->setImageFilename($newFilename);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirect($this->generateUrl('default'));
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
