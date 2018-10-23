<?php

namespace App\Controller\Api;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/user")
 */
class UserController extends BaseController
{
    /**
     * @Route("/", methods={"GET"})
     */
    public function index(Request $request)
    {
        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);

        if(!$user) {
            throw $this->createNotFoundException("No User Found");
        }

        $response = $this->createApiResponse($user, 200, ['details']);

        return $response;
    }

    /**
     * @Route("/new", methods={"POST"})
     */
    public function new(Request $request)
    {

    }
}
