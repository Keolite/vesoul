<?php


namespace App\Controller;

use App\Entity\Order;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

/**
 * Class Debug
 *
 * @package         App\Controller
 * @Route("/debug", name="debug")
 */
class Debug extends AbstractController
{

    private MailerInterface $mailer;

    public function __construct(
        MailerInterface $mailer
    ) {
        $this->mailer = $mailer;
    }


    /**
     * @Route("/test/mail", name="mail_test")
     * @return              RedirectResponse
     */
    public function testMail(): RedirectResponse
    {

        $emailAddress = $this->getUser()->getUsername();

        $mail = (new TemplatedEmail())
            ->from('admin')
            ->to($emailAddress)
            ->subject('Test Mailer')
            ->context([
                'firstname' =>  $this->getUser()->getFirstname()
            ])
            ->htmlTemplate('email/user_registration_confirmation.html.twig');

        try {
            $this->mailer->send($mail);
        } catch (TransportExceptionInterface $e) {
            dd($e);
        }

        return $this->redirectToRoute('dashboard_user_informations');
    }

    /**
     * @Route("/bill", name="test_bill")
     * @return         Response
     */
    public function testBill(): Response
    {
        $order = $this->getDoctrine()
            ->getRepository(Order::class)
            ->findOneBy([]);

        dd($order);

        return $this->render(
            'bill/bill.html.twig',
            [
                'order' => $order,
            ]
        );
    }
}
