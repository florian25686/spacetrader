<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\ApiRequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    public function __construct(
        public ApiRequestService $apiRequestService
    )
    {

    }

    #[Route('register/{username}/{faction}', name: 'registerUser', methods: ['GET'])]
    public function registerAgent(Request $request, string $username, string $faction = 'COSMIC'): Response
    {
        if (strlen($username) >= 14) {
            return new Response(
                'Username to long, must be below 14 characters.',
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $registerAgentRequest = $this->apiRequestService->getGuzzleClient()->request('POST', 'register',
        [
            'json' => [
                'symbol' => $username,
                'faction' => $faction,
            ]
        ]);

        if ($registerAgentRequest->getStatusCode() !== Response::HTTP_CREATED) {
            return new Response(
                json_decode($registerAgentRequest->getBody()->getContents()),
            Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return new Response(
            json_decode($registerAgentRequest->getBody()->getContents(), true)['token'],
            Response::HTTP_OK
        );
    }
}
