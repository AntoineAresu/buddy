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
        $night = new Night();
        $form = $this->createForm(NightType::class, $night)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dog->addNight($night);
            $em->flush();

            return $this->redirectToRoute('show_dashboard', ['id' => $dog->getId()]);
        }

        return $this->render('night/create.html.twig', [
            'form' => $form,
        ]);
    }
}
