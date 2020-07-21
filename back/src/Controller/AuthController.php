<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UserRepository;

class AuthController extends AbstractController
{
    /** @var UserRepository $userRepository */
    private $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/register", name="register", methods={"POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function register(Request $request)
    {
        $newUserData['email']    = $request->get('email');
        $newUserData['password'] = $request->get('password');

        $user = $this->userRepository->createNewUser($newUserData);

        return new Response(sprintf('User %s successfully created', $user->getUsername()));
    }
}
