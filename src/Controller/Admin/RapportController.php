<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Rapport;
use App\Form\RapportType;

use App\Entity\Consultant;
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
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        // Créer une nouvelle instance de Rapport
        $rapport = new Rapport();

        // Créer un formulaire pour la création de rapport
        $form = $this->createForm(RapportType::class, $rapport);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        // Vérifier si l'utilisateur actuel a l'autorisation de créer un rapport
        if ($this->isGranted('CREATE', $rapport)) {
            // L'utilisateur actuel a l'autorisation de créer un rapport

            // Obtenir l'utilisateur actuel
            $user = $security->getUser();

            // Vérifier si l'utilisateur est un Consultant
            if ($user instanceof User && $user->getConsultant() instanceof Consultant) {
                // L'utilisateur est un Consultant
                // Vérifier si le formulaire est soumis et valide
                if ($form->isSubmitted() && $form->isValid()) {
                    $rapport->setUser($user);
                    // Persiste le rapport dans la base de données
                    $entityManager->persist($rapport);
                    $entityManager->flush();

                    // Rediriger vers la page d'index des rapports après la création du rapport
                    return $this->redirectToRoute('app_rapport_index', [], Response::HTTP_SEE_OTHER);
                }
            } else {
                // L'utilisateur actuel n'est pas un Consultant
                // Vous pouvez gérer cette situation en affichant un message d'erreur ou en redirigeant vers une autre page
                // Dans cet exemple, nous redirigeons simplement l'utilisateur vers la page d'accueil
                return $this->redirectToRoute('app_admin_dashboard');
            }
        } else {
            // L'utilisateur actuel n'a pas l'autorisation de créer un rapport
            // Vous pouvez gérer cette situation en affichant un message d'erreur ou en redirigeant vers une autre page
            // Dans cet exemple, nous redirigeons simplement l'utilisateur vers la page d'accueil
            return $this->redirectToRoute('app_admin_dashboard');
        }

        // Afficher le formulaire de création de rapport
        return $this->render('Admin/rapport/new.html.twig', [
            'rapport' => $rapport,
            'form' => $form->createView(),
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


        // Récupérer le consultant actuel
        $consultant = $this->getUser(); // Supposons que vous utilisez Symfony pour gérer l'authentification

        // Assigner le consultant au rapport
        $rapport->setUser($consultant);

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
