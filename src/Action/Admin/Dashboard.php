<?php

namespace App\Action\Admin;

use App\Repository\ProjectRepository;
use App\Repository\TechnologyRepository;
use App\Responder\ViewResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class Dashboard
 * @package App\Action\Admin
 *
 * @Route("/admin", name="admin_dashboard")
 */
final class Dashboard
{

    /** @var ProjectRepository */
    protected $projectRepository;

    /** @var TechnologyRepository */
    protected $technologyRepository;

    /**
     * Dashboard constructor.
     * @param ProjectRepository $projectRepository
     * @param TechnologyRepository $technologyRepository
     */
    public function __construct(ProjectRepository $projectRepository, TechnologyRepository $technologyRepository)
    {
        $this->projectRepository = $projectRepository;
        $this->technologyRepository = $technologyRepository;
    }

    /**
     * @param ViewResponder $view
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __invoke(ViewResponder $view)
    {
        $project = $this->projectRepository->findAll();
        $technology = $this->technologyRepository->findAll();

        return $view('admin/dashboard.html.twig', [
            'project' => $project,
            'technology' => $technology
        ]);
    }
}
