<?php

namespace App\Action\Admin\Technology;

use App\Domain\Helper\FlashMessageHelper;
use App\Domain\Helper\FormHelper;
use App\Domain\Technology\TechnologyDTO;
use App\Domain\Technology\TechnologyType;
use App\Entity\Technology as TechnologyEntity;
use App\Repository\TechnologyRepository;
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
 * Class UpdateTechnology
 * @package App\Action\Admin\Technology
 *
 * @Route("/admin/technology/update/{slug}", name="admin_technology_update")
 */
final class UpdateTechnology
{

    /** @var FormHelper */
    protected $formHelper;

    /** @var TechnologyRepository */
    protected $technoRepository;

    /** @var EntityManagerInterface */
    protected $em;

    /** @var FlashMessageHelper */
    protected $flash;

    /**
     * UpdateTechnology constructor.
     * @param FormHelper $formHelper
     * @param TechnologyRepository $technologyRepository
     * @param EntityManagerInterface $em
     * @param FlashMessageHelper $flash
     */
    public function __construct(
        FormHelper $formHelper,
        TechnologyRepository $technologyRepository,
        EntityManagerInterface $em,
        FlashMessageHelper $flash
    ) {
        $this->formHelper = $formHelper;
        $this->technoRepository = $technologyRepository;
        $this->em = $em;
        $this->flash = $flash;
    }

    /**
     * @param Request $request
     * @param ViewResponder $responder
     * @param string $slug
     * @param RedirectResponder $redirect
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __invoke(Request $request, ViewResponder $responder, string $slug, RedirectResponder $redirect)
    {
        $technology = $this->technoRepository->findOneBy(['slug' => $slug]);
        $form = $this->formHelper->getFormType($request, TechnologyType::class, TechnologyDTO::class, $technology);

        if ($form->isSubmitted() && $form->isValid()) {
            TechnologyEntity::update($form->getData(), $technology);
            $this->em->flush();
            $this->flash->getFlashMessageUpdate();

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
