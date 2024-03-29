<?php

namespace App\Controller;

use App\Entity\SupOrga;
use App\Form\SupOrgaType;
use App\Repository\SupOrgaRepository;
use App\Service\ApiToBDDService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/suporga')]
class SupOrgaController extends AbstractController
{
    #[Route('/', name: 'app_sup_orga_index', methods: ['GET'])]
    public function index(SupOrgaRepository $supOrgaRepository, ApiToBDDService $api): Response
    {
        $api->updateSupOrgaList();
        return $this->render('sup_orga/index.html.twig', [
            'sup_orgas' => $supOrgaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_sup_orga_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $supOrga = new SupOrga();
        $form = $this->createForm(SupOrgaType::class, $supOrga);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($supOrga);
            $entityManager->flush();

            return $this->redirectToRoute('app_sup_orga_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sup_orga/new.html.twig', [
            'sup_orga' => $supOrga,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sup_orga_show', methods: ['GET'])]
    public function show(SupOrga $supOrga): Response
    {
        return $this->render('sup_orga/show.html.twig', [
            'sup_orga' => $supOrga,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sup_orga_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SupOrga $supOrga, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SupOrgaType::class, $supOrga);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_sup_orga_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sup_orga/edit.html.twig', [
            'sup_orga' => $supOrga,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sup_orga_delete', methods: ['POST'])]
    public function delete(Request $request, SupOrga $supOrga, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$supOrga->getId(), $request->request->get('_token'))) {
            $entityManager->remove($supOrga);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_sup_orga_index', [], Response::HTTP_SEE_OTHER);
    }
}
