<?php

namespace App\Action\Admin\Technology;

use App\Repository\TechnologyRepository;
use App\Responder\ViewResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class Technology
 * @package App\Action\Admin\Technology
 *
 * @Route("/admin/technology", name="admin_technology_index")
 */
final class Technology
{

    /** @var TechnologyRepository */
    protected $technologyRepository;

    /**
     * Technology constructor.
     * @param TechnologyRepository $technologyRepository
     */
    public function __construct(TechnologyRepository $technologyRepository)
    {
        $this->technologyRepository = $technologyRepository;
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
        return $responder('admin/technology/index.html.twig', [
            'technos' => $this->technologyRepository->findAll()
        ]);
    }
}
