<?php

namespace App\Controller;

use App\Entity\Login;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name:'login', methods:['POST'])]
function login(Request $request, ManagerRegistry $doctrine): Response
    {
    $em = $doctrine->getManager();
    $data = json_decode($request->getContent(), true);

    $userRepository = $em->getRepository(Login::class);
    $user = $userRepository->findOneBy(['login' => $data['login']]);

    if (!$user) {
        return $this->json(['message' => 'Invalid login.'], Response::HTTP_UNAUTHORIZED);
    }

    if ($data['password'] !== $user->getPassword()) {
        return $this->json(['message' => 'Invalid password.'], Response::HTTP_UNAUTHORIZED);
    }

    return $this->json($data['login']);
}

#[Route('/newuser', name:'newuser', methods:['POST'])]
function newuser(Request $request, ManagerRegistry $doctrine): Response
    {
    $em = $doctrine->getManager();
    $data = json_decode($request->getContent(), true);

    $userRepository = $em->getRepository(Login::class);
    $match = $userRepository->findOneBy(['login' => $data['login']]);

    if ($match) {
        return $this->json(['message' => 'Username already exists'], Response::HTTP_BAD_REQUEST);
    }

    $user = new Login();
    $user->setLogin($data['login']);
    $user->setPassword($data['password']);

    $em->persist($user);
    $em->flush();

    return $this->json(['message' => 'Account has been created'], Response::HTTP_CREATED);

}
}
