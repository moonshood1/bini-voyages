<?php

namespace App\Controller;

use App\Form\AccountType;
use App\Entity\PasswordUpdate;
use App\Form\PasswordUpdateType;
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
    public function user_login(AuthenticationUtils $utils)
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
    public function user_logout()
    {

    }


    /**
     * @Route("/admin/login", name="admin_account_login")
     * @return void
     */
    public function admin_login(AuthenticationUtils $utils) 
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();
        return $this->render('admin/account/login.html.twig', [
            'error' => $error !== null,
            'username' => $username,
        ]);
    }


    /**
     * @Route("/admin/logout", name="admin_account_logout")
     * @return void
     */
    public function admin_logout()
    {

    }


    /**
     * @Route("/account_check", name="account_check")
     */
    public function user_accountVerify()
    {
        return $this->render('account/check.html.twig');
    }


    /**
     * @Route("/account_confirm/{token}", name="account_confirm")
     * @param string $token
     */
    public function user_confirmAccount($token, UserRepository $repo,EntityManagerInterface $manager)
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
     * @Route("/admin/account/profile", name="admin_account_profile")
     * @return Response
     */
    public function admin_profile(Request $request, EntityManagerInterface $manager)
    {
        $user = $this->getUser();
        $form = $this->createForm(AccountType::class,$user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();

         return $this->redirectToRoute("admin_account");

        }

        return $this->render('admin/account/profile.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /** 
     * @Route("/account/profile",name="account_profile")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function user_profile(Request $request, EntityManagerInterface $manager)
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
     * @Route("admin/account/password-update", name="admin_account_password")
     * @return Response
     */
    public function admin_updatePassword(Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager)
    {
        $passwordUpdate = new PasswordUpdate();

        $user = $this->getUser();

        $form = $this->createForm(PasswordUpdateType::class,$passwordUpdate);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!password_verify($passwordUpdate->getOldPassword(), $user->getPassword())) {
               $form->get('oldPassword')->addError(new FormError("Le mot de passe actuel n'est pas correct"));
            } else {
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->encodePassword($user,$newPassword);

                $user->setPassword($hash);

                $manager->persist($user);
                $manager->flush();

                return $this->redirectToRoute("admin_home");
            }
        }
        return $this->render('admin/account/password.html.twig', [
            'form' => $form->createView()
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
    public function user_updatePassword(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
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
     * @Route("/admin/account", name="admin_account")
     */
    public function admin_myAccount(Request $request)
    {
        return $this->render('admin/account/account.html.twig', [
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/account", name="account_index")
     */
    public function user_myAccount()
    {
        return $this->render('account/account.html.twig', [
            'user' => $this->getUser(),
        ]);
    }
}
