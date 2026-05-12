<?php

namespace App\Controller;

use App\Entity\Crossing;
use App\Entity\Dog;
use App\Form\CrossingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class CrossingController extends AbstractController
{
    #[Route('/dog/{id}/crossing/create', name: 'create_crossing')]
    #[IsGranted('UPDATE', 'dog')]
    public function create(
        Request $request,
        Dog $dog,
        #[MapQueryParameter] string $date,
        EntityManagerInterface $em,
    ): Response {
        $date = $this->getDateFromQuery($date);

        $crossing = new Crossing()->setDog($dog)->setDate($date);
        $form = $this->createForm(CrossingType::class, $crossing)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($crossing);
            $em->flush();

            return $this->redirectToRoute('show_calendar_day', [
                'id' => $dog->getId(),
                'date' => $date->format('Y-m-d'),
            ]);
        }

        return $this->render('crossing/index.html.twig', [
            'dog' => $dog,
            'form' => $form,
        ]);
    }
}
