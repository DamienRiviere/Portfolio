<?php

namespace App\Domain\Common\EventSubscriber;

use App\Responder\ViewResponder;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ExceptionSubscriber implements EventSubscriberInterface
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

    public static function getSubscribedEvents(): array
    {
        return
        [
            KernelEvents::EXCEPTION => 'onException'
        ];
    }

    /**
     * @param ExceptionEvent $event
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function onException(ExceptionEvent $event): void
    {
        $statusCode = 500;
        $message = [
            'message' => $event->getThrowable()->getMessage()
        ];

        switch (get_class($event->getThrowable())) {
            case EntityNotFoundException::class:
                $statusCode = 404;
                break;
        }

        $event->setResponse(
            new Response(
                $this->templating->render(
                    'bundles/TwigBundle/Exception/error' . $statusCode . '.html.twig',
                    [
                        'exception' => $message
                    ]
                ),
                $statusCode
            )
        );
    }
}
