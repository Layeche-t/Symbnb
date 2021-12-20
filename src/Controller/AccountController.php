<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /** 
     * Pour ce  connecter 
     * @Route("/login", name="account_login")
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $usernme = $utils->getLastUsername();

        return $this->render('account/login.html.twig', [
            'hasError' => $error !== null,
            'username' => $usernme
        ]);
    }

    /**
     * Pour ce déconnecter 
     * @Route("/logout", name="account_logout")
     * 
     * @return void
     */

    public function logout()
    {
    }

    /**
     * Enregistrement
     * @Route("/register", name="account_register")
     *
     * @return Respons
     */
    public function register()
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        return $this->render('account/registraion.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
