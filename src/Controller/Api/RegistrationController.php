<?php

namespace App\Controller\Api;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('api/registration', name: 'api_registration', methods: ['POST'])]
    public function Register(Request $request): Response
    {
        $payload = json_decode($request->getContent(), true);
        $userGuid = $payload['guid'];

        $existingUser = $this->em->getRepository(Users::class)->findOneBy(['guid' => $userGuid]);
        if ($existingUser) {
            return $this->json(['error' => 'User with this ID already exists'], 409); // Код 409 для конфликтов
        }


        $newUser = new Users();
        $newUser->setGuid($userGuid);

        $this->em->persist($newUser);
        $this->em->flush();

        return $this->json(['message' => 'User registered successfully']);
    }
}