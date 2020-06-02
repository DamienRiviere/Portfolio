<?php

namespace App\Action\Admin\Project;

use App\Domain\Helper\FlashMessageHelper;
use App\Domain\Helper\FormHelper;
use App\Domain\Project\ProjectDTO;
use App\Domain\Project\ProjectType;
use App\Repository\ProjectRepository;
use App\Responder\RedirectResponder;
use App\Responder\ViewResponder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use App\Entity\Project;

/**
 * Class UpdateProject
 * @package App\Action\Admin\Project
 *
 * @Route("/admin/project/update/{slug}", name="admin_project_update")
 */
final class UpdateProject
{

    /** @var FormHelper */
    protected $formHelper;

    /** @var ProjectRepository */
    protected $projectRepository;

    /** @var EntityManagerInterface */
    protected $em;

    /** @var FlashMessageHelper */
    protected $flash;

    /**
     * UpdateProject constructor.
     * @param FormHelper $formHelper
     * @param ProjectRepository $projectRepository
     * @param EntityManagerInterface $em
     * @param FlashMessageHelper $flash
     */
    public function __construct(
        FormHelper $formHelper,
        ProjectRepository $projectRepository,
        EntityManagerInterface $em,
        FlashMessageHelper $flash
    ) {
        $this->formHelper = $formHelper;
        $this->projectRepository = $projectRepository;
        $this->em = $em;
        $this->flash = $flash;
    }

    /**
     * @param Request $request
     * @param ViewResponder $view
     * @param RedirectResponder $redirect
     * @param string $slug
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws EntityNotFoundException
     * @throws NonUniqueResultException
     */
    public function __invoke(Request $request, ViewResponder $view, RedirectResponder $redirect, string $slug)
    {
        $project = $this->projectRepository->findOneProject($slug);
        $form = $this->formHelper->getFormType($request, ProjectType::class, ProjectDTO::class, $project);

        if ($form->isSubmitted() && $form->isValid()) {
            Project::update($form->getData(), $project);
            $this->em->flush();
            $this->flash->getFlashMessageUpdate();

            return $redirect('admin_project_index');
        }

        return $view('admin/project/new_update.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
