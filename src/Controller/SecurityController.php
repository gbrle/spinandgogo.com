<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use App\Service\mailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

    /**
     * @Route("/registration", name="app_registration")
     */
    public function registration(Request $request, mailerService $mailer, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = New User();

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $user->setCredit(5);
            $user->setRoles($user->getRoles());
            $user->setActive(false);
            $user->setConfirmationToken($this->generateToken());
            $user->setCreatedAt(new \DateTime('now'));

            $token = $user->getConfirmationToken();

            $this->addFlash("success", "Votre inscription a été validée, 
            vous allez recevoir un email de confirmation pour activer votre compte et 
            pouvoir vous connecter. Si vous ne recevez pas de mail, vérifiez vos courriers indésirables.");

            $manager->persist($user);
            $manager->flush();

            // Send Mail Activation token
            $mailer->sendTokenConfirmationInscription(
                $user->getEmail(),
                "Confirmation compte",
                "https://spinandgogo.dg-web.fr/account/confirm/".$token."/".$user->getEmail() ,
                "mailsTemplates/sendConfirmationToken.html.twig"
            );

            return $this->redirectToRoute("app_login");
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/sendTokenActivation", name="app_sendTokenActivation")
     */
    public function sendTokenActivation(SessionInterface $session, Request $request, mailerService $mailer, UserRepository $userRepository)
    {

        $user = $userRepository->findOneBy(['email' => $session->get('email')]);
        $token = $user->getConfirmationToken();

        // Send Mail Activation token
        $mailer->sendTokenConfirmationInscription(
            $user->getEmail(),
            "Confirmation compte",
            "https://spinandgogo.dg-web.fr/account/confirm/".$token."/".$user->getEmail() ,
            "mailsTemplates/sendConfirmationToken.html.twig"
        );
        $this->addFlash("success", "Un liens de confirmation de compte vous a été envoyé, vérifiez votre boite mail. (Vérifier courriers indésirables)");

        return $this->redirectToRoute("app_login");
    }

    /**
     * @Route("/account/confirm/{token}/{email}", name="confirm_account")
     */
    public function confirmAccount($token, $email, UserRepository $userConfirm, EntityManagerInterface $manager)
    {

        $user = $userConfirm->findOneBy(['email' => $email]);
        $tokenUser = $user->getConfirmationToken();
        if($token === $tokenUser) {
            $user->setActive(true);
            $manager->persist($user);
            $manager->flush();

            $this->addFlash("success", "Votre compte est activé " . $user->getFirstname() . ". Vous pouvez maintenant vous connecter !");

            return $this->redirectToRoute('app_login');
        } else {
            // TODO : Donner la possibilité de cliquer sur un lien pour regénérer un lien token valide

            $this->addFlash("danger", "Ce lien a expiré");

            return $this->redirectToRoute('app_login');
        }
    }

    /**
     * @Route("/forgottenPassword", name="forgotten_password")
     */
    public function forgottenPassword(Request $request, UserRepository $userRepository, mailerService $mailerService, EntityManagerInterface $manager)
    {
        if($request->isMethod('POST')) {
            $email = $request->get('email');
            $user = $userRepository->findOneBy(['email' => $email]);

            if($user){
                $token = $this->generateToken();
                $user->setResetPasswordToken($token);

                $manager->persist($user);
                $manager->flush();

                $this->addFlash("success", "Un mail vous de réinitialisation de votre mot de passe vous a été envoyé, verifiez vos courriers indésirable.");

                $mailerService->sendForgottenPasswordLink(
                    $user->getEmail(),
                    "Réinitialisation mot de passe",
                    "https://spinandgogo.dg-web.fr/resetPassword/".$user->getResetPasswordToken() ,
                    "mailsTemplates/forgottenPassword.html.twig" ,
                    $user->getFirstname().' '. $user->getLastname());

                return $this->redirectToRoute("app_login");
            } else {
                $this->addFlash("error", "Cet utilisateur n'existe pas !");
            }
        }

        return $this->render('security/forgottenPassword.html.twig');
    }

    /**
     * @Route("/resetPassword/{token}", name="reset_password")
     */
    public function resetPassword(Request $request, $token, UserPasswordEncoderInterface $encoder, UserRepository $userRepository, EntityManagerInterface $manager){
        $user = $userRepository->findOneBy(['resetPasswordToken' => $token]);

        $form = $this->createForm(ResetPasswordType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $this->addFlash("success", "Votre mot de passe a bien été modifié.");

            $manager->persist($user);
            $manager->flush();


            return $this->redirectToRoute("app_login");
        }
        return $this->render('security/resetPassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    public function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }
}