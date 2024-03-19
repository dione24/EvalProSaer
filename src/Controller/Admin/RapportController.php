<?php

namespace App\Controller\Admin;

use App\Entity\Rapport;
use App\Form\RapportType;
use App\Repository\RapportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/rapport')]
class RapportController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/', name: 'app_rapport_index', methods: ['GET'])]
    public function index(RapportRepository $rapportRepository): Response
    {
        // Vérifiez si l'utilisateur est administrateur ou manager
        if ($this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_MANAGER')) {
            // Si oui, récupérez tous les rapports
            $rapports = $rapportRepository->findAll();
        } else {
            // Sinon, récupérez les rapports associés à l'utilisateur actuel
            $rapports = $rapportRepository->findRapportByUser($this->getUser());
        }

        return $this->render('Admin/rapport/index.html.twig', [
            'rapports' => $rapports,
        ]);
    }

    #[Route('/new', name: 'app_rapport_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $rapport = new Rapport();
        $form = $this->createForm(RapportType::class, $rapport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rapport);
            $entityManager->flush();

            return $this->redirectToRoute('app_rapport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Admin/rapport/new.html.twig', [
            'rapport' => $rapport,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rapport_show', methods: ['GET'])]
    public function show(Rapport $rapport): Response
    {
        return $this->render('Admin/rapport/show.html.twig', [
            'rapport' => $rapport,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_rapport_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Rapport $rapport, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RapportType::class, $rapport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_rapport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Admin/rapport/edit.html.twig', [
            'rapport' => $rapport,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rapport_delete', methods: ['POST'])]
    public function delete(Request $request, Rapport $rapport, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $rapport->getId(), $request->request->get('_token'))) {
            $entityManager->remove($rapport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_rapport_index', [], Response::HTTP_SEE_OTHER);
    }
}
