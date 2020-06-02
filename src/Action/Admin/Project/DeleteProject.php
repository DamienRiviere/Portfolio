<?php

namespace App\Action\Admin\Project;

use App\Domain\Helper\FlashMessageHelper;
use App\Responder\RedirectResponder;
use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DeleteProject
 * @package App\Action\Admin\Project
 *
 * @Route("/admin/project/delete/{id}", name="admin_project_delete")
 */
final class DeleteProject
{

    /** @var EntityManagerInterface */
    protected $em;

    /** @var FlashMessageHelper */
    protected $flash;

    /**
     * DeleteProject constructor.
     * @param EntityManagerInterface $em
     * @param FlashMessageHelper $flash
     */
    public function __construct(EntityManagerInterface $em, FlashMessageHelper $flash)
    {
        $this->em = $em;
        $this->flash = $flash;
    }


    public function __invoke(Project $project, RedirectResponder $redirect)
    {
        unlink("uploads/" . $project->getPicture()->getName());

        $this->em->remove($project);
        $this->em->flush();
        $this->flash->getFlashMessageDelete();

        return $redirect('admin_project_index');
    }
}
