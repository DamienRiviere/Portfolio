<?php

namespace App\Responder;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class ViewResponder
{

    /** @var Environment */
    protected $templating;

    /**
     * ViewResponder constructor.
     * @param Environment $templating
     */
    public function __construct(Environment $templating)
    {
        $this->templating = $templating;
    }

    /**
     * @param string $template
     * @param array $paramsTemplate
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __invoke(string $template, array $paramsTemplate = [])
    {
        return new Response($this->templating->render($template, $paramsTemplate));
    }
}
