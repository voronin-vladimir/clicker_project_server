<?php

namespace App\Controller\Api;

use App\Entity\Player;
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
        $guid = $payload['guid'];

        $existingUser = $this->em->getRepository(Player::class)->findOneBy(['guid' => $guid]);
        if ($existingUser) {
            return $this->json(['error' => 'User with this ID already exists'], 409); // Код 409 для конфликтов
        }

        $newPlayer = new Player();
        $newPlayer->setGuid($guid);

        $this->em->persist($newPlayer);
        $this->em->flush();

        return $this->json(['message' => 'User registered successfully']);
    }
}