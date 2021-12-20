<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /** 
     * Pour ce  connecter 
     * @Route("/login", name="account_login")
     */
    public function login()
    {
        return $this->render('account/login.html.twig');
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
}
