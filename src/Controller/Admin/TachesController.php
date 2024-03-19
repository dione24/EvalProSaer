<?php

namespace App\Controller\Admin;

use App\Entity\Taches;
use App\Form\TachesType;
use App\Repository\TachesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/taches')]
class TachesController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/', name: 'app_taches_index', methods: ['GET'])]
    public function index(TachesRepository $tachesRepository): Response
    {
        // Vérifiez si l'utilisateur est administrateur ou manager
        if ($this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_MANAGER')) {
            // Si oui, récupérez toutes les tâches
            $taches = $tachesRepository->findAll();
        } else {
            // Sinon, récupérez les tâches associées à l'utilisateur actuel
            $taches = $tachesRepository->findTachesByUser($this->getUser());
        }
        return $this->render('Admin/taches/index.html.twig', [
            'taches' => $taches,
        ]);
    }

    #[Route('/new', name: 'app_taches_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tach = new Taches();
        $form = $this->createForm(TachesType::class, $tach);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tach);
            $entityManager->flush();

            return $this->redirectToRoute('app_taches_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('Admin/taches/new.html.twig', [
            'tach' => $tach,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_taches_show', methods: ['GET'])]
    public function show(Taches $tach): Response
    {
        return $this->render('Admin/taches/show.html.twig', [
            'tach' => $tach,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_taches_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Taches $tach, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TachesType::class, $tach);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_taches_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Admin/taches/edit.html.twig', [
            'tach' => $tach,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_taches_delete', methods: ['POST'])]
    public function delete(Request $request, Taches $tach, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tach->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tach);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_taches_index', [], Response::HTTP_SEE_OTHER);
    }
}
