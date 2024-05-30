<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TweetImpactController extends AbstractController
{
    #[Route('/tweet/impact', name: 'app_tweet_impact')]
    public function index(): Response
    {
        return $this->render('tweet_impact/index.html.twig', [
            'controller_name' => 'TweetImpactController',
        ]);
    }
}
