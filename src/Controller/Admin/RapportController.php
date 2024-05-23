<?php

namespace App\Controller\Admin;

use OpenAI;
use App\Entity\User;

use App\Entity\Projet;
use App\Entity\Rapport;
use App\Form\RapportType;
use App\Entity\Consultant;
use App\Service\RapportService;
use App\Repository\RapportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/rapport')]
class RapportController extends AbstractController
{
    private $security;
    private $rapportService;

    public function __construct(Security $security, RapportService $rapportService)
    {
        $this->security = $security;
        $this->rapportService = $rapportService;
    }

    #[Route('/', name: 'app_rapport_index', methods: ['GET'])]
    public function index(RapportRepository $rapportRepository): Response
    {
        if ($this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_MANAGER')) {
            // Si oui, récupérez tous les rapports
            $rapports = $rapportRepository->findAll();
        } else {
            // Sinon, récupérez les rapports associés à l'utilisateur actuel
            $rapports = $rapportRepository->findUserRapport($this->getUser());
        }

        return $this->render('Admin/rapport/index.html.twig', [
            'rapports' => $rapports,
        ]);
    }


    #[Route('/new/{id}', name: 'app_rapport_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security, Projet $projet): Response
    {
        $rapport = new Rapport();
        $form = $this->createForm(RapportType::class, $rapport);
        $form->handleRequest($request);
        if ($this->isGranted('CREATE', $rapport)) {
            $user = $security->getUser();
            // if ($user instanceof User && $user->getConsultant() instanceof Consultant) {
            if ($form->isSubmitted() && $form->isValid()) {
                $rapport->setUser($user);
                $rapport->setProjet($projet);
                $rapport->setCreatedAt(new \DateTimeImmutable());
                $entityManager->persist($rapport);
                $entityManager->flush();
                $this->addFlash('success', 'Rapport ajouté avec succès');

                return $this->redirectToRoute('app_rapport_index', [], Response::HTTP_SEE_OTHER);
            }
            // } else {
            //     return $this->redirectToRoute('app_admin_dashboard');
            // }
        } else {

            return $this->redirectToRoute('app_admin_dashboard');
        }
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
            $this->addFlash('success', 'Rapport modifié avec succès');

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
    #[Route('/{id}/evaluation', name: 'admin_rapport_evaluation', methods: ['POST'])]
    public function evaluation(Request $request, Rapport $rapport): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN or ROLE_MANAGER');
        $this->rapportService->addEvaluation($rapport, $this->getUser(), $request->request->get('content'));
        $this->addFlash('success', 'Evaluation ajoutée avec succès');
        return $this->redirectToRoute('app_rapport_show', ['id' => $rapport->getId()], Response::HTTP_SEE_OTHER);
    }


    #[Route('/ai/rapport', name: 'rapport', methods: ['POST'])]
    public function reponse(Request $request): Response
    {
        $yourApiKey = $_ENV['OPENAI_API_KEY'] ?? null;
        if (!$yourApiKey) {
            return new JsonResponse(['error' => 'API key not found'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $client = OpenAI::client($yourApiKey);

        // Assurez-vous que comments est bien un tableau
        /** @var array|null $comments */
        $comments = $request->request->get('comments');

        if (!is_array($comments)) {
            return new JsonResponse(['error' => 'No comments provided or invalid format'], Response::HTTP_BAD_REQUEST);
        }

        $prompt = "Fais un résumé des commentaires suivants : \n\n" . implode("\n\n", $comments);

        $result = $client->chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        $responseContent = $result->choices[0]->message->content;

        return new JsonResponse(['response' => $responseContent]);
    }
}