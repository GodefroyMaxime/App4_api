<?php

namespace App\Controller;

use App\Entity\Seniorities;
use App\Form\SenioritiesType;
use App\Repository\SenioritiesRepository;
use App\Service\ApiToBDDService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/seniorities')]
class SenioritiesController extends AbstractController
{
    #[Route('/', name: 'app_seniorities_index', methods: ['GET'])]
    public function index(SenioritiesRepository $senioritiesRepository, ApiToBDDService $api): Response
    {
        $api->updateSenioritiesList();
        return $this->render('seniorities/index.html.twig', [
            'seniorities' => $senioritiesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_seniorities_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $seniority = new Seniorities();
        $form = $this->createForm(SenioritiesType::class, $seniority);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($seniority);
            $entityManager->flush();

            return $this->redirectToRoute('app_seniorities_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('seniorities/new.html.twig', [
            'seniority' => $seniority,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_seniorities_show', methods: ['GET'])]
    public function show(Seniorities $seniority): Response
    {
        return $this->render('seniorities/show.html.twig', [
            'seniority' => $seniority,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_seniorities_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Seniorities $seniority, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SenioritiesType::class, $seniority);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_seniorities_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('seniorities/edit.html.twig', [
            'seniority' => $seniority,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_seniorities_delete', methods: ['POST'])]
    public function delete(Request $request, Seniorities $seniority, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$seniority->getId(), $request->request->get('_token'))) {
            $entityManager->remove($seniority);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_seniorities_index', [], Response::HTTP_SEE_OTHER);
    }
}
