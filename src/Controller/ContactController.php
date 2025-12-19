<?php

namespace App\Controller;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $contact = new Contact();
            $contact->setName($request->request->get('name'));
            $contact->setEmail($request->request->get('email'));
            $contact->setSubject($request->request->get('subject'));
            $contact->setMessage($request->request->get('message'));
            $contact->setCreatedAt(new \DateTime());

            $em->persist($contact);
            $em->flush();

            $this->addFlash('success', 'Message envoyé avec succès !');
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig');
    }
}
