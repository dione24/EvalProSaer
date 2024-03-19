<?php

namespace App\Controller\Admin;

use App\Entity\Consultant;
use App\Form\ConsultantType;
use App\Repository\ConsultantRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/consultant')]
class ConsultantController extends AbstractController
{
    #[Route('/', name: 'app_consultant_index', methods: ['GET'])]
    public function index(ConsultantRepository $consultantRepository): Response
    {
        return $this->render('Admin/consultant/index.html.twig', [
            'consultants' => $consultantRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_consultant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $consultant = new Consultant();

        $form = $this->createForm(ConsultantType::class, $consultant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($consultant);
            $entityManager->flush();

            return $this->redirectToRoute('app_consultant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Admin/consultant/new.html.twig', [
            'consultant' => $consultant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_consultant_show', methods: ['GET'])]
    public function show(Consultant $consultant): Response
    {
        return $this->render('Admin/consultant/show.html.twig', [
            'consultant' => $consultant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_consultant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Consultant $consultant, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ConsultantType::class, $consultant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_consultant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Admin/consultant/edit.html.twig', [
            'consultant' => $consultant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_consultant_delete', methods: ['POST'])]
    public function delete(Request $request, Consultant $consultant, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $consultant->getId(), $request->request->get('_token'))) {
            $entityManager->remove($consultant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_consultant_index', [], Response::HTTP_SEE_OTHER);
    }
}
