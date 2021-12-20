<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        $manager = $this->getDoctrine()->getManager();


        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getHash());
            $user->setHash($hash);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre compte bien été crée ! Vous pouvez maintenant vous connecter !"
            );

            return $this->redirectToRoute('account_login');
        }


        return $this->render('account/registraion.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
