<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends AbstractController
{

    protected function createApiResponse($data, $statusCode = 200, $groups = [])
    {
        $json = $this->serialize($data, $groups);
        return new Response($json, $statusCode, [
           'Content-Type' => 'application/json'
        ]);
    }


    protected function serialize($data, $groups)
    {
        return $this->container->get('serializer')
                    ->serialize($data,'json', ['groups'=>$groups]);
    }
}