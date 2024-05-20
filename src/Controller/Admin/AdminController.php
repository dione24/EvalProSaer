<?php

namespace App\Controller\Admin;

use App\Entity\Taches;
use App\Repository\ProjetRepository;
use App\Repository\TachesRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/')]
class AdminController extends AbstractController
{
    private $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/dashboard', name: 'app_admin_dashboard')]
    public function index(ProjetRepository $projetRepository, TachesRepository $tachesRepository): Response
    {
        if ($this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_MANAGER')) {
            $projets = $projetRepository->findAll();
            $taches = $tachesRepository->findAll();
        } else {
            $projets = $projetRepository->findUserProject($this->getUser());
            $taches = $tachesRepository->findUserTaches($this->getUser());
        }

        return $this->render('Admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'projets' => $projets,
            'taches' => $taches,
        ]);
    }

    #[Route('/calendar', name: 'app_admin_calendar')]
    public function calendar(): Response
    {
        return $this->render('Admin/calendar/calendar.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    //calendar get API
    #[Route('/calendar/events', name: 'app_admin_calendar_events', methods: ['GET'])]
    public function calendarEvents(TachesRepository $tachesRepository): Response
    {
        $taches = $tachesRepository->findAll();
        $data = [];
        foreach ($taches as $tache) {
            $data[] = [
                'id' => $tache->getId(),
                'title' => $tache->getDescription(),
                'start' => $tache->getDateDebut()->format('Y-m-d H:i:s'),
                'end' => $tache->getDateFin()->format('Y-m-d H:i:s'),
            ];
        }
        return $this->json($data);
    }
}
