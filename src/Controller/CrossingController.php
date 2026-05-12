<?php

namespace App\Controller;

use App\Entity\Crossing;
use App\Entity\Dog;
use App\Form\CrossingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class CrossingController extends AbstractController
{
    #[Route('/dog/{id}/day/{date<\d{4}-\d{2}-\d{2}>}/crossing/create', name: 'create_crossing')]
    #[IsGranted('UPDATE', 'dog')]
    public function create(Request $request, Dog $dog, ?\DateTime $date, EntityManagerInterface $em): Response
    {
        $crossing = new Crossing()->setDog($dog)->setDate($date ?? new \DateTime());
        $form = $this->createForm(CrossingType::class, $crossing)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($crossing);
            $em->flush();

            return $this->redirectToRoute('show_calendar_day', [
                'id' => $dog->getId(),
                'date' => $date?->format('Y-m-d'),
            ]);
        }

        return $this->render('crossing/index.html.twig', [
            'dog' => $dog,
            'form' => $form,
        ]);
    }
}
