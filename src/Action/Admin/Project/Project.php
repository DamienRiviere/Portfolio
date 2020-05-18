<?php

namespace App\Action\Admin\Project;

use App\Repository\ProjectRepository;
use App\Responder\ViewResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class Project
 * @package App\Action\Admin\Project
 *
 * @Route("/admin/project", name="admin_project_index")
 */
final class Project
{

    /** @var ProjectRepository */
    protected $projectRepository;

    /**
     * Project constructor.
     * @param ProjectRepository $projectRepository
     */
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
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
        return $view('admin/project/index.html.twig', [
            'projects' => $this->projectRepository->findAll()
        ]);
    }
}
