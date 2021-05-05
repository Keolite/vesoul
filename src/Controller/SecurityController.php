<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use App\Manager\MailManager;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Manager\CartManager;

class SecurityController extends AbstractController
{
    private AuthenticationUtils $authenticationUtils;
    private UserPasswordEncoderInterface $encoder;
    private MailManager $mailer;
    private EntityManagerInterface $manager;
    private CartManager $cartManager;

    public function __construct(
        AuthenticationUtils $authenticationUtils,
        UserPasswordEncoderInterface $encoder,
        MailManager $mailer,
        EntityManagerInterface $manager,
        CartManager $cartManager
    ) {
        $this->authenticationUtils = $authenticationUtils;
        $this->encoder = $encoder;
        $this->mailer = $mailer;
        $this->manager = $manager;
        $this->cartManager = $cartManager;
    }

    /**
     * @Route("/connexion", name="login")
     */
    public function login(): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('dashboard_user_home');
        }

        $error = $this->authenticationUtils->getLastAuthenticationError();
        $lastUsername = $this->authenticationUtils->getLastUsername();
        $cart = $this->cartManager->getCurrentCart();


        return $this->render(
            'security/login.html.twig',
            [
                'last_username' => $lastUsername,
                'error' => $error,
                'cart' => $cart
            ]
        );
    }


    /**
     * @Route("/deconnexion", name="logout")
     */
    public function logout()
    {
    }


    /**
     * @Route("/inscription", name="registration")
     * @param                 Request $request
     * @return                RedirectResponse|Response
     */
    public function registration(Request $request)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user)->handleRequest($request);
        $cart = $this->cartManager->getCurrentCart();


        if ($form->isSubmitted() && $form->isValid()) {

            // if form is ok : hash user's password and save infos
            $hash = $this->encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash)->setRoles(['ROLE_USER']);

            $this->manager->persist($user);
            $this->manager->flush();

            // Confirm subscription

            //send email registration confirmation
            try {
                $this->mailer->sendRegistrationMail($user);
                $this->addFlash('success', "Félicitation ! Un email de confirmation vous a été envoyé");
            } catch (TransportExceptionInterface $e) {
                $this->addFlash('danger', "Un problème est survenu lors de l'envoi de votre email de confirmation");
            }

            return $this->redirectToRoute('login');
        }

        return $this->render(
            'security/registration.html.twig',
            [
                'form' => $form->createView(),
                'cart' => $cart
            ]
        );
    }
}
