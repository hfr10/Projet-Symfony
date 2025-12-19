<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/profile')]
class ProfileController extends AbstractController
{
    #[Route('', name: 'app_profile')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('profile/index.html.twig', ['user' => $this->getUser()]);
    }

    #[Route('/edit', name: 'app_profile_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        if ($request->isMethod('POST')) {
            $user->setFirstname($request->request->get('firstname'));
            $user->setLastname($request->request->get('lastname'));
            $user->setUpdatedAt(new \DateTime());

            $em->flush();

            $this->addFlash('success', 'Profil mis à jour !');
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profile/edit.html.twig', ['user' => $user]);
    }

    #[Route('/delete', name: 'app_profile_delete', methods: ['POST'])]
    public function delete(EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('app_logout');
    }
}
