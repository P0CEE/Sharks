<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route('/', name: 'app_homepage')]
    public function index(UserRepository $userRepository, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $pageSize = 7; 
    
        [$users, $totalItems, $totalPages] = $this->paginateUsers($userRepository, $page, $pageSize);
    
        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
            'users' => $users,
            'currentPage' => $page,
            'totalItems' => $totalItems,
            'itemsPerPage' => $pageSize,
            'totalPages' => $totalPages
        ]);
    }
    
    private function paginateUsers(UserRepository $userRepository, int $page, int $pageSize): array
    {
        $users = $userRepository->findAllUsersWithPointsAndRank();
    
        // Paginate the users array
        $offset = ($page - 1) * $pageSize;
        $paginatedUsers = array_slice($users, $offset, $pageSize);
        $totalItems = count($users);
        $totalPages = (int) ceil($totalItems / $pageSize);
    
        return [$paginatedUsers, $totalItems, $totalPages];
    }
}
