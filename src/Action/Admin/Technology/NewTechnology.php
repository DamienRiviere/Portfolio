<?php

namespace App\Action\Admin\Technology;

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

    /**
     * NewTechnology constructor.
     * @param FormHelper $formHelper
     * @param EntityManagerInterface $em
     */
    public function __construct(FormHelper $formHelper, EntityManagerInterface $em)
    {
        $this->formHelper = $formHelper;
        $this->em = $em;
    }

    /**
     * @param Request $request
     * @param ViewResponder $responder
     * @param RedirectResponder $redirect
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __invoke(Request $request, ViewResponder $responder, RedirectResponder $redirect)
    {
        $form = $this->formHelper->getFormType($request, TechnologyType::class);

        if ($form->isSubmitted() && $form->isValid()) {
            $technology = Technology::create($form->getData());
            $this->em->persist($technology);
            $this->em->flush();

            return $redirect('admin_technology_index');
        }

        return $responder(
            'admin/technology/new_update_technology.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}
