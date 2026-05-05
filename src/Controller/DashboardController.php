<?php

namespace App\Controller;

use App\Entity\Dog;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class DashboardController extends AbstractController
{
    #[Route('/dog/{id<\d+>}/dashboard', name: 'show_dashboard')]
    #[IsGranted('UPDATE', 'dog')]
    public function calendar(Dog $dog): Response
    {
        return $this->render('dashboard/show.html.twig', [
            'dog' => $dog,
        ]);
    }
}
