<?php

namespace App\Domain\Authentication;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

/**
 * Class LoginAuthenticator
 * @package App\Domain\Authentication
 */
class LoginAuthenticator extends AbstractFormLoginAuthenticator
{

    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var UserRepository */
    protected $userRepository;

    /** @var UserPasswordEncoderInterface */
    protected $encoder;

    /** @var UrlGeneratorInterface */
    protected $urlGenerator;

    /** @var SessionInterface */
    protected $session;

    /**
     * LoginAuthenticator constructor.
     * @param FormFactoryInterface $formFactory
     * @param UserRepository $userRepository
     * @param UserPasswordEncoderInterface $encoder
     * @param UrlGeneratorInterface $urlGenerator
     * @param SessionInterface $session
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        UserRepository $userRepository,
        UserPasswordEncoderInterface $encoder,
        UrlGeneratorInterface $urlGenerator,
        SessionInterface $session
    ) {
        $this->formFactory = $formFactory;
        $this->userRepository = $userRepository;
        $this->encoder = $encoder;
        $this->urlGenerator = $urlGenerator;
        $this->session = $session;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request)
    {
        return $request->isMethod('POST') && $request->attributes->get('_route') === 'authentication_login';
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getCredentials(Request $request)
    {
        $form = $this->formFactory->create(LoginType::class)
                                  ->handleRequest($request);

        return $form->getData();
    }

    /**
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     * @return User|UserInterface|null
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $user =
            !is_null($credentials->getEmail()) ?
                $this->userRepository->loadUserByUsername($credentials->getEmail()) :
                null
        ;

        if (is_null($user)) {
            throw new CustomUserMessageAuthenticationException('Adresse email ou mot de passe invalide !');
        }

        return $user;
    }

    /**
     * @param mixed $credentials
     * @param UserInterface $user
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        if (
            is_null($credentials->getPassword()) ||
            !$this->encoder->isPasswordValid($user, $credentials->getPassword())
        ) {
            throw new CustomUserMessageAuthenticationException('Adresse ou mot de passe invalide !');
        }

        return true;
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     * @return RedirectResponse|Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new RedirectResponse(
            $this->urlGenerator->generate('admin_dashboard')
        );
    }

    /**
     * @return string
     */
    protected function getLoginUrl()
    {
        return $this->urlGenerator->generate('authentication_login');
    }
}
