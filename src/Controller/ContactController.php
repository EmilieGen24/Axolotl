<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();

            $email = (new Email())
                ->from('expediteur@gmail.com')
                ->to('destination@live.fr')
                ->subject('Nouveau message de contact')
                ->text(
                    "Nom: {$data['name']}\n".
                    "Email: {$data['email']}\n\n".
                    "Message: {$data['message']}"
                );
                $mailer->send($email);
        }
        return $this->render('contact/contact.html.twig', [
            'form' =>$form->createView(),
        ]);
    }
}