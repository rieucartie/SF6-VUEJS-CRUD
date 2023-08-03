<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
class AuthController extends AbstractController
{
  public function __construct(
    private UserRepository $userRepository,
    private SerializerInterface $serializer
  )
  {
    
  }

  #[Route('/register', name: 'user.register')]
  public function register(Request $request) : JsonResponse
  {

    $jsonData = json_decode($request->getContent());

    $user = $this->userRepository->create($jsonData);

    return new JsonResponse([
      'user' => $this->serializer->serialize($user, 'json')
    ]);
  }

  #[Route('/profile', name: 'user.profile')]
  public function profile() : JsonResponse
  {
    $currentUser = $this->getUser();
    $user = $this->serializer->serialize($currentUser, 'json');
    return new JsonResponse([
      $user
    ], 200);
  }

    #[Route('/login', name: 'user.login')]
    public function login() : JsonResponse
    {
        $currentUser = $this->getUser();
        $user = $this->serializer->serialize($currentUser, 'json');
        return new JsonResponse([
            $user
        ], 200);
    }

}