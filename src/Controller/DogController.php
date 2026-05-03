<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class DogController extends AbstractController
{
    #[Route('/dogs', name: 'list_dogs')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function dogs(): Response
    {
        return $this->render('dog/list.html.twig', [
            'dogs' => $this->getUser()?->getDogs(),
        ]);
    }
}
