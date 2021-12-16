<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Image;
use App\Form\AdType;
use App\Repository\AdRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{

    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repo)
    {

        $ads = $repo->findAll();


        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
        ]);
    }


    /**
     * Création de formulaires
     * @Route ("/ads/new", name="ads_create")
     *
     * @return Response 
     */
    public function create(Request $request)
    {
        $ad = new Ad();

        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);

        // alert 
        $manager = $this->getDoctrine()->getManager();

        // insert data in database
        if ($form->isSubmitted() && $form->isValid()) {


            foreach ($ad->getImages() as $image) {
                $image->setAd($ad);
                $manager->persist($image);
            }


            $manager->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'annonce <strong>{$ad->getTitle()}</strong> a bien été enregistrée !"
            );

            return $this->redirectToRoute('ads_show', [
                'slug' => $ad->getSlug()
            ]);
        }


        return $this->render('ad/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher un formulaire de modification
     * 
     * @Route("/ads/{slug}/edit", name="ads_edit")
     * 
     * @return Respons
     */
    public function edit(Ad $ad, Request $request)
    {

        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);

        $manager = $this->getDoctrine()->getManager();

        // insert data in database
        if ($form->isSubmitted() && $form->isValid()) {


            foreach ($ad->getImages() as $image) {
                $image->setAd($ad);
                $manager->persist($image);
            }


            $manager->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les modifications de l'annonce <strong>{$ad->getTitle()}</strong> ont bien été enregistrées !"
            );

            return $this->redirectToRoute('ads_show', [
                'slug' => $ad->getSlug()
            ]);
        }

        return $this->render('ad/edit.html.twig', [
            'form' => $form->createView(),
            'ad' => $ad
        ]);
    }




    /**
     * Pour afficher une annonce 
     * 
     * @Route("/ads/{slug}", name="ads_show")
     * 
     * @return  Response
     */

    public function show(Ad $ad)
    {
        return $this->render('ad/show.html.twig', [
            'ad' => $ad
        ]);
    }
}
