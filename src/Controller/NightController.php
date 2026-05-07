<?php

namespace App\Controller;

use App\Entity\Dog;
use App\Entity\Night;
use App\Form\NightType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class NightController extends AbstractController
{
    #[Route('/dog/{id<\d+>}/night/create', name: 'create_night')]
    #[IsGranted('UPDATE', 'dog')]
    public function create(Request $request, Dog $dog, EntityManagerInterface $em): Response
    {
        $night = new Night()->setDog($dog);
        $form = $this->createForm(NightType::class, $night)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($night);
            $em->flush();

            return $this->redirectToRoute('show_dashboard', ['id' => $dog->getId()]);
        }

        return $this->render('night/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/night/{id<\d+>}/update', name: 'update_night')]
    #[IsGranted('UPDATE', 'night')]
    public function update(Request $request, Night $night, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(NightType::class, $night)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('show_dashboard', ['id' => $night->getDog()->getId()]);
        }

        return $this->render('night/create.html.twig', [
            'form' => $form,
        ]);
    }
}
