<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\ApiRequestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AgentController extends AbstractController
{
    public function __construct(
        public ApiRequestService $apiRequestService,
    )
    {
    }

   #[Route('agent', name: 'agent.overview', methods: ['GET'])]
    public function viewAgentData(): Response
    {
        $agentResponse = $this->apiRequestService->getGuzzleClient()->request(
            'GET',
            'my/agent',
            [
                'headers' => ['Authorization' => 'Bearer ' . $this->apiRequestService->getAgentToken() ],
            ]
        );
        $agentData = json_decode($agentResponse->getBody()->getContents(), true);

        return $this->render('agent/data.html.twig', [
            'agentData' => $agentData['data'],
        ]);
    }

    #[Route('agent/ships', name: 'agent.ships', methods: ['GET'])]
    public function viewAgentShips(): Response
    {
        $agentResponse = $this->apiRequestService->getGuzzleClient()->request(
            'GET',
            'my/ships',
            [
                'headers' => ['Authorization' => 'Bearer ' . $this->apiRequestService->getAgentToken() ],
            ]
        );
        $agentShipsResponse = $agentResponse->getBody()->getContents();

        return $this->render('agent/ships.html.twig', [
            'ships' => json_decode($agentShipsResponse, true)['data'],
        ]);
    }
}
