<?php

namespace App\Action;

use App\Repository\ProjectRepository;
use App\Responder\ViewResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class Home
 * @package App\Action
 *
 * @Route("/", name="home")
 */
final class Home
{

    /** @var ProjectRepository */
    protected $projectRepository;

    /**
     * Home constructor.
     * @param ProjectRepository $projectRepository
     */
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * @param ViewResponder $responder
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __invoke(ViewResponder $responder)
    {
        return $responder('home/index.html.twig', [
            'projects' => $this->projectRepository->findAll()
        ]);
    }
}
