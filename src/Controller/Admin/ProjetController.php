<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\Projet;
use DateTimeImmutable;
use App\Entity\Fichiers;
use App\Form\ProjetType;
use App\Service\Comment;
use App\Entity\Commentaires;
use App\Service\UploadFiles;
use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/projet')]
class ProjetController extends AbstractController
{

    private $security;
    private $commentService;
    private $uploadFiles;

    public function __construct(Security $security, Comment $commentService, UploadFiles $uploadFiles)
    {
        $this->security = $security;
        $this->commentService = $commentService;
        $this->uploadFiles = $uploadFiles;
    }

    #[Route('/', name: 'app_projet_index', methods: ['GET'])]
    public function index(ProjetRepository $projetRepository): Response
    {
        // Vérifiez si l'utilisateur est administrateur ou manager
        if ($this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_MANAGER')) {
            // Si oui, récupérez tous les projets
            $projets = $projetRepository->findAll();
        } else {
            // Sinon, récupérez les projets associés à l'utilisateur actuel
            $projets = $projetRepository->findProjetByUser($this->getUser());
        }

        return $this->render('Admin/projet/index.html.twig', [
            'projets' => $projets,
        ]);
    }

    #[Route('/new', name: 'app_projet_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $projet->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($projet);
            $entityManager->flush();

            return $this->redirectToRoute('app_projet_index', [], Response::HTTP_SEE_OTHER);
        }

        $this->addFlash('success', 'Projet ajouté avec succès');
        return $this->render('Admin/projet/new.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_projet_show', methods: ['GET'])]
    public function show(Projet $projet): Response
    {

        return $this->render('Admin/projet/show.html.twig', [
            'projet' => $projet,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_projet_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Projet $projet, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_projet_index', [], Response::HTTP_SEE_OTHER);
        }

        $this->addFlash('success', 'Projet modifié avec succès');
        return $this->render('Admin/projet/edit.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_projet_delete', methods: ['POST'])]
    public function delete(Request $request, Projet $projet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $projet->getId(), $request->request->get('_token'))) {
            $entityManager->remove($projet);
            $entityManager->flush();
        }
        $this->addFlash('success', 'Projet supprimé avec succès');

        return $this->redirectToRoute('app_projet_index', [], Response::HTTP_SEE_OTHER);
    }
    //Comment Service
    #[Route('/{id}/commentaire', name: 'app_projet_comment_create', methods: ['POST'])]
    public function createCommentaire(Request $request, Projet $projet): Response
    {
        $content = $request->request->get('content');
        $this->commentService->createCommentaire($projet, $content);
        $this->addFlash('success', 'Commentaire ajouté avec succès');
        return $this->redirectToRoute('app_projet_show', ['id' => $projet->getId()], Response::HTTP_SEE_OTHER);
    }
    #[Route('/commentaire/delete/{id}', name: 'app_projet_comment_delete', methods: ['POST'])]
    public function deleteCommentaire(Request $request, Commentaires $commentaire): Response
    {
        $this->commentService->deleteCommentaire($commentaire);

        $this->addFlash('success', 'Commentaire supprimé avec succès');
        return $this->redirectToRoute('app_projet_show', ['id' => $commentaire->getProjet()->getId()], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{id}/commentaire/{commentaireId}/edit', name: 'app_projet_comment_edit', methods: ['POST'])]
    public function editCommentaire(Request $request, Commentaires $commentaire): Response
    {
        $content = $request->request->get('content');
        $this->commentService->updateCommentaire($commentaire, $content);
        return $this->redirectToRoute('app_projet_show', ['id' => $commentaire->getProjet()->getId()], Response::HTTP_SEE_OTHER);
    }
    //app_projet_files_upload
    #[Route('/{id}/files/upload', name: 'app_projet_files_upload', methods: ['POST'])]
    public function uploadFiles(Request $request, Projet $projet): Response
    {
        $files = $request->files->get('file');
        $this->uploadFiles->uploadFile($files, $projet);
        $this->addFlash('success', 'Fichier ajouté avec succès');
        return $this->redirectToRoute('app_projet_show', ['id' => $projet->getId()], Response::HTTP_SEE_OTHER);
    }

    //app_projet_files_delete
    #[Route('/files/delete/{id}', name: 'app_projet_files_delete', methods: ['POST'])]
    public function deleteFiles(Fichiers $fichier, EntityManagerInterface $entityManager): Response
    {
        $projetId = $fichier->getProjet()->getId();

        // Get the file path
        $filePath = $this->getParameter('files_directory') . '/' . $fichier->getName();

        // Check if the file exists
        if (file_exists($filePath)) {
            // Delete the file from the repository
            unlink($filePath);
        }

        // Remove the entity from the database
        $entityManager->remove($fichier);
        $entityManager->flush();
        $this->addFlash('success', 'Fichier supprimé avec succès');
        return $this->redirectToRoute('app_projet_show', ['id' => $projetId], Response::HTTP_SEE_OTHER);
    }

    //app_projet_files_download
    #[Route('/uploads/{fileName}', name: 'download_file', methods: ['GET'])]
    public function downloadFile($fileName): Response
    {
        $filePath = $this->getParameter('files_directory') . '/' . $fileName;

        // Send the file as a response
        return new BinaryFileResponse($filePath);
    }
}
