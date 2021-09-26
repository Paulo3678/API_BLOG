<?php

namespace App\ExceptionHandlers;

use App\Helper\ResponseFactory;
use Doctrine\ORM\ORMException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionHandle implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => [
                ["exception404handle", 0],
                ["ormExceptionHandle", 1]
            ]
        ];
    }

    // TAKE CARE OF NotFoundHttpException
    public function exception404handle(ExceptionEvent $exception)
    {
        if ($exception->getThrowable() instanceof NotFoundHttpException) {

            $response = ResponseFactory::exceptionMaker([
                "error" => "Path not found!!!",
                "type" => "NotFoundHttpException",
                "path" => $_SERVER["REQUEST_URI"]
            ]);
            $exception->setResponse(new JsonResponse($response));
        }
    }

    // TAKE CARE OF ORMException
    public function ormExceptionHandle(ExceptionEvent $exception)
    {
        if ($exception->getThrowable() instanceof ORMException) {
            $response = ResponseFactory::exceptionMaker([
                "error" => "Invalid Query name!!",
                "query" => str_replace(" ", "", explode(":", $exception->getThrowable()->getMessage())[1]),
                "type" => "ORMException",
                "path" => $_SERVER["REQUEST_URI"]
            ]);
            $exception->setResponse(new JsonResponse($response));
        }
    }
}
