<?php

namespace App\Manager;

use App\Entity\Order;
use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class MailManager
{

    private MailerInterface $mailer;
    private string $adminEmailAddress;


    public function __construct(
        MailerInterface $mailer,
        string $adminEmailAddress
    ) {
        $this->mailer = $mailer;
        $this->adminEmailAddress = $adminEmailAddress;
    }

    /**
     * @param  Order $order
     * @return void
     */
    public function sendNewOrderMail(Order $order): void
    {
        $user = $order->getUser()->getUsername();
        $admin = $this->adminEmailAddress;

        // send mail to user
        $mail = (new TemplatedEmail())
            ->from($admin)
            ->to($user)
            ->subject('Confirmation de votre commande')
            ->htmlTemplate('email/user_order_confirmation.html.twig');

        $this->mailer->send($mail);
    }


    /**
     * @param  Order $order
     * @return void
     */
    public function contactAdmin(Order $order): void
    {
        $admin = $this->adminEmailAddress;

        // send mail to user
        $mail = (new TemplatedEmail())
            ->from(new Address($admin, 'Vesoul Edition'))
            ->to(new Address($admin, 'Christian'))
            ->subject('Nouvelle commande')
            ->context([
                'order' => $order
            ])
            ->htmlTemplate('email/admin_new_order.html.twig');

        $this->mailer->send($mail);
    }


    /**
     * @param  User $user
     * @return void
     */
    public function sendRegistrationMail(User $user): void
    {
        $admin = $this->adminEmailAddress;
        $userAddress = $user->getUsername();

        // send mail to user
        $mail = (new TemplatedEmail())
            ->from(new Address($admin, 'Vesoul Edition'))
            ->to($userAddress)
            ->subject('Inscription Vesoul Edition')
            ->context([
                'firstname' => $user->getFirstname()
            ])
            ->htmlTemplate('email/user_registration_confirmation.html.twig');

        $this->mailer->send($mail);
    }
}
