<?php

namespace App\Action\Admin\Technology;

use App\Domain\Helper\FlashMessageHelper;
use App\Responder\RedirectResponder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Technology;

/**
 * Class DeleteTechnology
 * @package App\Action\Admin\Technology
 *
 * @Route("/admin/technology/delete/{id}", name="admin_technology_delete")
 */
final class DeleteTechnology
{

    /** @var EntityManagerInterface */
    protected $em;

    /** @var FlashMessageHelper */
    protected $flash;

    /**
     * DeleteTechnology constructor.
     * @param EntityManagerInterface $em
     * @param FlashMessageHelper $flash
     */
    public function __construct(EntityManagerInterface $em, FlashMessageHelper $flash)
    {
        $this->em = $em;
        $this->flash = $flash;
    }

    /**
     * @param Technology $technology
     * @param RedirectResponder $redirect
     * @return RedirectResponse
     */
    public function __invoke(Technology $technology, RedirectResponder $redirect)
    {
        $this->em->remove($technology);
        $this->em->flush();
        $this->flash->getFlashMessageDelete();

        return $redirect('admin_technology_index');
    }
}
