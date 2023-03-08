<?php

namespace App\Controller;

use App\Repository\IngredientRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(UserRepository $userRepository, IngredientRepository $ingredientRepository) : Response
    {
        $users = $userRepository->findAll();
        $ingredients = $ingredientRepository->findAll();

        return $this->render('home/index.html.twig', [
            'users' => $users,
            'ingredients' => $ingredients,
        ]);
    }
}
