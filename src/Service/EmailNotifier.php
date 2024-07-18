<?php

namespace App\Service;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class EmailNotifier
{
public function __construct(  private MailerInterface $mailer,
                              private EntityManagerInterface $entityManager)
{

}
    public function notifyAdmin( UserInterface $user, TemplatedEmail $email):void
    {
        $context = $email->getContext();

        // @todo add route for superadmin
//        $context['url'] = ;
        $email->context($context);

        $this->mailer->send($email);


    }
}
