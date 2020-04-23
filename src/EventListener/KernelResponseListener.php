<?php 
namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class KernelResponseListener
{
    public function onKernelResponse(ResponseEvent $event)
    {
        // Customize your response object to display the exception details
        // $response = new Response("Hello");
        // $event->setResponse($response);


    }
}