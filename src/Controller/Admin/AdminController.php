<?php

namespace App\Controller\Admin;

use App\Entity\Taches;
use App\Repository\ProjetRepository;
use App\Repository\TachesRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    private $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/admin/dashboard', name: 'app_admin_dashboard')]
    public function index(ProjetRepository $projetRepository, TachesRepository $tachesRepository): Response
    {
        // Vérifiez si l'utilisateur est administrateur ou manager
        if ($this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_MANAGER')) {
            // Si oui, récupérez tous les projets
            $projets = $projetRepository->findAll();
        } else {
            // Sinon, récupérez les projets associés à l'utilisateur actuel
            $projets = $projetRepository->findProjetByUser($this->getUser());
        }

        $taches = $tachesRepository->findTachesByUser($this->getUser());
        return $this->render('Admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'projets' => $projets,
            'taches' => $taches,
        ]);
    }

    #[Route('/admin/calendar', name: 'app_admin_calendar')]
    public function calendar(): Response
    {
        return $this->render('Admin/calendar.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
