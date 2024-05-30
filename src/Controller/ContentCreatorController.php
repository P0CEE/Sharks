<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContentCreatorController extends AbstractController
{
    #[Route('/content/creator', name: 'app_content_creator')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findContentCreators();

        return $this->render('content_creator/index.html.twig', [
            'controller_name' => 'ContentCreatorController',
            'users' => $users,
        ]);
    }
}
