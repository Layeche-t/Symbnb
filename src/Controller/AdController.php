<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AdController extends AbstractController
{

    /**
     * @Route("/ads", name="ad_index")
     */
    public function index(AdRepository $repo)
    {

        $ads = $repo->findAll();


        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
        ]);
    }

    /**
     * Pour afficher une annonce 
     * 
     * @Route("/ads/{slug}", name="ads_show")
     * 
     * @return  Response
     */

    public function show($slug, AdRepository $repo)
    {
        //récupération des annonces 
        $ad = $repo->findOneBySlug($slug);

        return $this->render('ad/show.html.twig', [
            'ad' => $ad
        ]);
    }
}
