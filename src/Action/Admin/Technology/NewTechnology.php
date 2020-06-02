<?php

namespace App\Action\Admin\Technology;

use App\Domain\Helper\FlashMessageHelper;
use App\Domain\Helper\FormHelper;
use App\Domain\Technology\TechnologyType;
use App\Entity\Technology;
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
 * Class NewTechnology
 * @package App\Action\Admin\Technology
 *
 * @Route("/admin/technology/new", name="admin_technology_new")
 */
final class NewTechnology
{

    /** @var FormHelper */
    protected $formHelper;

    /** @var EntityManagerInterface */
    protected $em;

    /** @var FlashMessageHelper */
    protected $flash;

    /**
     * NewTechnology constructor.
     * @param FormHelper $formHelper
     * @param EntityManagerInterface $em
     * @param FlashMessageHelper $flash
     */
    public function __construct(FormHelper $formHelper, EntityManagerInterface $em, FlashMessageHelper $flash)
    {
        $this->formHelper = $formHelper;
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
        $form = $this->formHelper->getFormType($request, TechnologyType::class, null);

        if ($form->isSubmitted() && $form->isValid()) {
            $technology = Technology::create($form->getData());
            $this->em->persist($technology);
            $this->em->flush();
            $this->flash->getFlashMessageCreate();

            return $redirect('admin_technology_index');
        }

        return $view(
            'admin/technology/new_update.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}
