<?php

namespace App\Action;

use App\Domain\Authentication\LoginType;
use App\Responder\ViewResponder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class Login
 * @package App\Action
 *
 * @Route("/admin/login", name="authentication_login")
 */
final class Login
{

    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var AuthenticationUtils */
    protected $authenticationUtils;

    public function __construct(FormFactoryInterface $formFactory, AuthenticationUtils $authenticationUtils)
    {
        $this->formFactory = $formFactory;
        $this->authenticationUtils = $authenticationUtils;
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
        $form = $this->formFactory->create(LoginType::class);

        return $responder('authentication/login.html.twig', [
            'form' => $form->createView(),
            'error' => $this->authenticationUtils->getLastAuthenticationError()
        ]);
    }
}
