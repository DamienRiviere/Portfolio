<?php

namespace App\Action\Admin;

use App\Responder\ViewResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class Dashboard
 * @package App\Action\Admin
 *
 * @Route("/admin", name="admin_dashboard")
 */
final class Dashboard
{

    /**
     * @param ViewResponder $responder
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __invoke(ViewResponder $responder)
    {
        return $responder('admin/dashboard.html.twig');
    }
}
