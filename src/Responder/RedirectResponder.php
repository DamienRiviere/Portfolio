<?php

namespace App\Responder;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class RedirectResponder
{

    /** @var UrlGeneratorInterface */
    protected $urlGenerator;

    /**
     * RedirectResponder constructor.
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param string $routeName
     * @param array $paramsRoute
     * @param int $statusCode
     * @return RedirectResponse
     */
    public function __invoke(string $routeName, array $paramsRoute = [], int $statusCode = Response::HTTP_FOUND): RedirectResponse
    {
        return new RedirectResponse($this->urlGenerator->generate($routeName, $paramsRoute), $statusCode);
    }
}
