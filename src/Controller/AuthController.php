<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class AuthController extends AbstractController
{
    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $firstname = $request->request->get('firstname') ?? 'Utilisateur';
            $lastname = $request->request->get('lastname') ?? '';

            if (!$email || !$password) {
                $this->addFlash('error', 'Email et mot de passe requis');
                return $this->redirectToRoute('app_register');
            }

            $user = new User();
            $user->setEmail($email);
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setPassword($passwordHasher->hashPassword($user, $password));
            $user->setCreatedAt(new \DateTime());

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Compte créé avec succès !');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('auth/register.html.twig');
    }
}
