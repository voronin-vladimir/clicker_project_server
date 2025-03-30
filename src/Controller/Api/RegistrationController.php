<?php

namespace App\Controller\Api;

use App\Entity\Player;
use App\Services\Player\PlayerService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends AbstractController
{
    private EntityManagerInterface $em;
    private PlayerService $playerService;

    public function __construct(EntityManagerInterface $em, PlayerService $playerService)
    {
        $this->em = $em;
        $this->playerService = $playerService;
    }

    #[Route('api/registration', name: 'api_registration', methods: ['POST'])]
    public function Register(Request $request): Response
    {
        $payload =  json_decode($request->getContent(), true);
        $guid = $payload['guid'];

        try
        {
            $this->playerService->registerPlayer($guid);
            $response = $this->json(['message' => 'User registered successfully'], 201);
        }
        catch (Exception $exception)
        {
            $response = $this->json(['error' => $exception->getMessage()], $exception->getCode());
        }

        return $response;
    }
}