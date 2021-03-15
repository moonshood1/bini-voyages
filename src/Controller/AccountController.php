<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/login", name="account_login")
     * @param AuthenticationUtils $utils
     * @return void
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();
        return $this->render('account/login.html.twig', [
            'hasError' => $error !== null,
            'username' => $username,
        ]);
    }

    /**
     * @Route("/logout", name="account_logout")
     * @return void
     */
    public function logout()
    {

    }

    /**
     * Route("/register", name="account_register")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setToken(sha1(mt_rand(1, 90000) . 'SALT'));

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute("account_check");
        }

        return $this->render('account/registration.html.twig', [
            'form' => $form->createView()
        ]);        
    }

    /**
     * @Route("/account_check", name="account_check")
     */
    public function accountVerify()
    {
        return $this->render('account/check.html.twig');
    }

    /**
     * @Route("/account_confirm/{token}", name="account_confirm")
     * @param string $token
     */
    public function confirmAccount($token, UserRepository $repo,EntityManagerInterface $manager)
    {
        $user = $repo->findOneBy(["token"=> $token]);

        if ($user) {
            $user->setToken("null");
            $manager->persist($user);
            $manager->flush(); 
            
            return $this->redirectToRoute("account_login");
        }
        return $this->json($token);
    }

    /** 
     * @Route("/account/profile",name="account_profile")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function profile(Request $request, EntityManagerInterface $manager)
    {
        $user = $this->getUser();
        $form = $this->createForm(AccountType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute("account_index");
        }

        return $this->render('account/profile.html.twig', [
            'form' => $form->createView(),
            'user' => $this->getUser()
        ]);
    }
    /**
     * @IsGranted("ROLE_USER")
     * @Route("account/password-update", name="account_password")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function updatePassword(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $passwordUpdate = new PasswordUpdate();
        $user = $this->getUser();
        $form= $this->createForm(PasswordUpdateType::class,$passwordUpdate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!password_verify($passwordUpdate->getOldPassword(),$user->getPassword())) {
                $form->get('oldPassword')->addError(new FormError("Le mot de passe entré n'est pas correct"));
            } else {
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->encodePassword($user,$newPassword);

                $user->setPassword($hash);

                $manager->persist($user);
                $manager->flush();

                return $this->redirectToRoute("account_index");
            }
        }

        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),
            'user' => $this->getUser()
        ]);

    }

    /**
     * @Route("/account", name="account_index")
     */
    public function myAccount()
    {
        return $this->render('account/account.html.twig', [
            'user' => $this->getUser(),
        ]);
    }
}
