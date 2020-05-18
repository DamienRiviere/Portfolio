<?php

namespace App\Action\Admin\Project;

use App\Domain\Helper\FlashMessageHelper;
use App\Domain\Helper\FormHelper;
use App\Domain\Project\ProjectType;
use App\Domain\Service\FileUploader;
use App\Entity\Picture;
use App\Entity\Project;
use App\Responder\RedirectResponder;
use App\Responder\ViewResponder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class NewProject
 * @package App\Action\Admin\Project
 *
 * @Route("/admin/project/new", name="admin_project_new")
 */
final class NewProject
{

    /** @var FormHelper */
    protected $formHelper;

    /** @var FileUploader */
    protected $upload;

    /** @var string */
    protected $uploadDir;

    /** @var EntityManagerInterface */
    protected $em;

    /** @var FlashMessageHelper */
    protected $flash;

    /**
     * NewProject constructor.
     * @param FormHelper $formHelper
     * @param string $uploadDir
     * @param EntityManagerInterface $em
     * @param FlashMessageHelper $flash
     */
    public function __construct(
        FormHelper $formHelper,
        string $uploadDir,
        EntityManagerInterface $em,
        FlashMessageHelper $flash
    ) {
        $this->formHelper = $formHelper;
        $this->uploadDir = $uploadDir;
        $this->upload = new FileUploader($this->uploadDir);
        $this->em = $em;
        $this->flash = $flash;
    }

    /**
     * @param Request $request
     * @param ViewResponder $view
     * @param RedirectResponder $redirect
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __invoke(Request $request, ViewResponder $view, RedirectResponder $redirect)
    {
        $form = $this->formHelper->getFormType($request, ProjectType::class);

        if ($form->isSubmitted() && $form->isValid()) {
            $newFileName = $this->upload->upload($form->getData()->getPicture());
            $project = Project::create($form->getData());
            $picture = Picture::create($newFileName, $form->getData(), $project);

            $this->em->persist($project);
            $this->em->persist($picture);
            $this->em->flush();

            $this->flash->getFlashMessageCreate();

            return $redirect("admin_project_index");
        }

        return $view("admin/project/new_update.html.twig", [
            'form' => $form->createView()
        ]);
    }
}
